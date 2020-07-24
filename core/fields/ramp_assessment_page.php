<?php namespace RampAssessment\Core;
global $pagenow;

$groups_items = [];
$groups = learndash_get_groups();
if(is_array($groups)){
    foreach( $groups as $term ){
        $groups_items[$term->ID] = $term->post_title;
    }
}

if( Functions::is_active_plugin_by_name( 'quform.php' ) ){
    $forms = [];
    if( is_admin() && ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) ){
        $forms = QuestionnairePage::get_questions_and_options_of_forms();
    }
    if( sizeOf( $forms ) != 0 ){
        if( sizeOf( $groups ) != 0 ){
            $xbox->add_tab( array(
                'id' => 'tabs',
                'items' => array(
                    'info' => __( 'General', 'textdomain' ),
                    'import-export' => __( 'Import/Export', 'textdomain' ),
                ),
            ) );
            $xbox->open_tab_item( 'info' );
            $daily_forms = get_posts( array(
                'fields' => [ 'ids' ],
                'posts_per_page' => -1,
                'post_type' => 'ramp_assessment',
                'order' => 'ASC',
            ) );
            $xbox->add_field( [
                'name' => __( 'Position', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'id' => 'position',
                'type' => 'number',
                'default' => sizeof( $daily_forms ) + 1,
                'options' => array(
                    'show_unit' => false,
                    'show_spinner' => true,
                ),
                'attributes' => array(
                    'min' => 1,//Default: 'null'
                    'step' => 1,
                    'precision' => 0,
                )
            ] );

            $xbox->add_field( [
                'name' => __( 'Description', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'id' => 'description',
                'type' => 'textarea',
            ] );

            $xbox->add_field( [
                'id' => 'student-group',
                'name' => __( 'Student Group', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'desc' => 'Select a student category',
                'type' => 'select',
                'items' => $groups_items,
                'options' => [
                    'multiple' => true,
                    'max_selections' => sizeof( $groups )
                ],
            ] );
            /* $xbox->add_field( [
                'id' => 'data',
                'type' => 'hidden',
                'default' => json_encode( $forms )
            ] ); */
            $forms_ids = [];
            foreach( $forms as $form_id => $form ){
                $forms_ids [$form_id] = $form['name'];
            }
            $xbox->add_field( [
                'id' => 'form',
                'name' => __( 'Form', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'desc' => 'Select a Quform',
                'type' => 'select',
                'items' => $forms_ids,
            ] );

            $xbox->add_field( [
                'id' => 'show_results',
                'name' => __( 'Show Results?', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'type' => 'radio',
                'default' => 'no',
                'items' => [
                    'no' => 'No',
                    'yes' => 'Yes',
                ],
            ] );

            $group01 = $xbox->add_group( array(
                'name' => 'Score',
                'id' => 'score',
                'options' => array(
                    'add_item_text' => __('New Score', RAMP_ASSESSMENT_TEXT_DOMAIN),
                    'show_if' => [ "show_results", '==', 'yes' ]
                ),
                'controls' => array(
                    'name' => 'Score #'
                )
            ));
            $group01->add_field(array(
                'id' => 'score_label',
                'name' => __( 'Label', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                'type' => 'text',
            ));

            $group01->add_field( [
                'id' => 'score_min_value' ,
                'name' => __( 'Min' , RAMP_ASSESSMENT_TEXT_DOMAIN ) ,
                'type' => 'number' ,
                'default' => 0 ,
                'options' => [
                    'unit' => 'PT' ,
                    'show_unit' => true ,
                    'show_spinner' => true ,
                ] , 'attributes' => [
                    'min' => 0 ,
                    'step' => 1 ,
                    'precision' => 0 ,
                ] ,
            ] );
            $group01->add_field( [
                'id' => 'score_max_value' ,
                'name' => __( 'Max' , RAMP_ASSESSMENT_TEXT_DOMAIN ) ,
                'type' => 'number' ,
                'default' => 0 ,
                'options' => [
                    'unit' => 'PT' ,
                    'show_unit' => true ,
                    'show_spinner' => true ,
                ] , 'attributes' => [
                    'min' => 0 ,
                    'step' => 1 ,
                    'precision' => 0 ,
                ] ,
            ] );

            foreach( $forms as $form_id => $form ){
                $group = $xbox->add_group( array(
                    'name' => 'Charts',
                    'id' => "charts-$form_id",
                    'options' => array(
                        'add_item_text' => __( 'New chart', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                        'show_if' => [ 'form', '==', $form_id ]
                    ),
                    'controls' => array(
                        'name' => 'Chart #'
                    )
                ) );
                $group->add_field( [
                    'id' => 'title',
                    'name' => __( 'Title', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                    'type' => 'text',
                ] );
                $group->add_field( [
                    'id' => 'chart-type',
                    'name' => __( 'Chart Type', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                    'type' => 'select',
                    'items' => [
                        'pie' => 'Pie',
                        'line' => 'Line',
                        'bars' => 'Bars',
                    ],
                ] );
                $questions = $form['questions'];
                $options_list = $form['options'];
                $group->add_field( [
                    'id' => "question-$form_id",
                    'name' => __( 'Question', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                    'type' => 'select',
                    'items' => $questions,
                    'repeatable' => 'true',
                ] );
                $options_items = [];
                foreach( $options_list as $key => $options ){
                    $options_items[$key] = implode( $options, ', ' );
                }
                if( ! empty( $options_items ) ){
                    $group->add_field( [
                        'id' => "options-$form_id",
                        'name' => __( 'Options', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                        'type' => 'select',
                        'default' => 'none',
                        'items' => $options_items,
                    ] );
                    $group->add_field( [
                        'id' => "legend",
                        'name' => __( 'Legend', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                        'type' => 'radio',
                        'desc' => 'The chart legend',
                        'default' => 'yes',
                        'items' => [ 'yes' => 'Yes', 'no' => 'No' ],
                    ] );
                }
                foreach( $options_list as $key => $options ){
                    $options_values = [];
                    foreach( $options as $option_id => $option ){
                        $options_values[implode( [ $option_id, $option ], '____' )] = $option;
                    }
                    $group->add_field( [
                        'id' => "list-$form_id-$key",
                        'name' => __( 'Options list', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                        'default' => array( '$all$' ),// Add $all$ if you need to activate all by default. ;)
                        'type' => 'checkbox',
                        'items' => $options_values,
                        'options' => array(
                            'in_line' => false,
                            'show_if' => [ "options-$form_id", '==', $key ]
                        )
                    ] );
                }

                $group->add_field( [
                    'id' => 'sum-of-options',
                    'name' => __( 'Sum of options?', RAMP_ASSESSMENT_TEXT_DOMAIN ),
                    'type' => 'radio',
                    'default' => 'no',
                    'items' => [
                        'no' => 'No',
                        'yes' => 'Yes',
                    ],
                ] );
            }


            $xbox->close_tab_item( 'info' );
            $xbox->open_tab_item( 'import-export' );
            $xbox->add_import_field( array(
                'name' => 'Import',
                'default' => 'from_file',
                'desc' => 'Select file, then click import button',
            ) );
            $xbox->add_export_field( array(
                'name' => 'Export',
                'desc' => 'Download and make a backup of your options.',
                'options' => array(
                    'export_button_text' => __( 'Download', 'xbox' ),
                    'export_file_name' => 'xbox-backup-file',//Name of the json file for backup.
                )
            ) );
            $xbox->close_tab_item( 'import-export' );
        } else{
            $xbox->add_field( [
                'id' => 'custom-title',
                'name' => __( 'Groups not found' ),
                'type' => 'title',
                'desc' => 'Please create a student category for use this section.',
            ] );
        }
    } else{
        // TODO: Show message for install form plugin
        $xbox->add_field( [
            'id' => 'custom-title',
            'name' => __( 'Forms in QUFORM not found' ),
            'type' => 'title',
            'desc' => 'Please create a form in Quform for use this section.',
        ] );
    }

} else{
    $xbox->add_field( [
        'id' => 'custom-title',
        'name' => __( 'QUFORM is desactived', RAMP_ASSESSMENT_TEXT_DOMAIN ),
        'type' => 'title',
        'desc' => 'Please active Quform for use this section.',
    ] );
}
