<?php namespace RampAssessment\Core;

class QuestionnairePage {

    public static function get_forms_list(){
        global $wpdb;
        $tableFormName = $wpdb->prefix . 'quform_forms';
        $rows = $wpdb->get_results( "SELECT * FROM $tableFormName" );
        return $rows;
    }

    public static function get_forms_list_json(){
        global $wpdb;
        $tableFormName = $wpdb->prefix . 'quform_forms';
        $rows = $wpdb->get_results( "SELECT * FROM $tableFormName" );
        $items = [];
        foreach( $rows as $row ){
            $items[$row->id] = $row->name;
            $items['data'] = json_encode( maybe_unserialize( base64_decode( trim( $row->config ) ) ) );
        }
        return $items;
    }

    public static function simple( &$group, $form ){
        global $wpdb;
        $tableFormName = $wpdb->prefix . 'quform_forms';
        $rows = $wpdb->get_results( "SELECT id,name,config FROM $tableFormName WHERE id=$form" );
        $items = [];
        foreach( $rows as $row ){
            $items[$row->id] = $row->name;
            $items['data'] = maybe_unserialize( base64_decode( trim( $row->config ) ) );
            $pages = [ $items['data'] ][0]['elements'];
            foreach( $pages as $page ){
                $questions = $page['elements'];
                foreach( $questions as $key => $question ){
                    if( 'radio' == $question['type'] ){
                        $options = [ 'null' => 'Not consider' ];
                        foreach( $question['options'] as $option ){
                            $options[$option['value']] = $option['value'];
                        }
                        $label = $question['label'];
                        $group->open_mixed_field( [ 'name' => "Question: $label" ] );
                        $id = $question['id'];
                        $type = $question['type'];
                        $group->add_field( [
                            'id' => "quform_$form" . "_$id",
                            'name' => "Answer $id - Type: $type",
                            'type' => 'select',
                            'default' => 'null',
                            'items' => $options,
                        ] );
                        $group->close_mixed_field();
                    }
                }
            }
        }
    }

    public static function get_questions_for_considerate( $form ){
        global $wpdb;
        $rows = $wpdb->get_results( "SELECT id,name,config FROM wp_quform_forms WHERE id=$form" );
        $items = [];
        $items_checkbox = [];
        foreach( $rows as $row ){
            $items[$row->id] = $row->name;
            $items['data'] = maybe_unserialize( base64_decode( trim( $row->config ) ) );
            $pages = [ $items['data'] ][0]['elements'];
            foreach( $pages as $page ){
                $questions = $page['elements'];
                // print_r('<pre>' . json_encode($questions, JSON_PRETTY_PRINT) . '</pre>');
                foreach( $questions as $key => $question ){
                    if( 'radio' == $question['type'] ){
                        $label = $question['label'];
                        $id = $question['id'];
                        $type = $question['type'];
                        $items_checkbox["quform_$form" . "_$id"] = $label;
                    }
                }
            }
        }
        return $items_checkbox;
    }

    public static function get_questions_and_options_of_forms( $with_types = false ){
        global $wpdb;
        $rows = $wpdb->get_results( "SELECT id,name,config FROM wp_quform_forms" );
        $items = [];
        $forms = [];
        foreach( $rows as $row ){
            $items_checkbox = [];
            $items[$row->id] = $row->name;
            $items['data'] = maybe_unserialize( base64_decode( trim( $row->config ) ) );
            $pages = [ $items['data'] ][0]['elements'];
            $options = [];
            foreach( $pages as $page ){
                $questions = $page['elements'];
                foreach( $questions as $key => $question ){
                    if( 'submit' != $question['type'] ){
                        $label = $question['label'];
                        $id = $question['id'];
                        $type = $question['type'];
                        if( $with_types ){
                            $items_checkbox["quform_{$row->id}" . "_$id"]['label'] = $label;
                            $items_checkbox["quform_{$row->id}" . "_$id"]['type'] = $type;
                        } else{
                            $items_checkbox["quform_{$row->id}" . "_$id"] = $label;
                        }
                        if( in_array( $type, array( 'select', 'radio' ), true ) ){
                            // print_r( '<pre>' . json_encode( $question['options'], JSON_PRETTY_PRINT ) . '</pre>' );
                            $options_of_question = [];
                            foreach( $question['options'] as $option ){
                                $options_of_question[$option['value']] = $option['label'];
                            }
                            $options["quform_{$row->id}" . "_$id"] = $options_of_question;
                        }
                    }
                }
            }
            $unique_options = Functions::super_unique( $options );
            $forms[$row->id] = [ 'questions' => $items_checkbox, 'options' => $unique_options, 'name' => $row->name ];
        }
        return $forms;
    }

    public static function get_questions_simple( $form ){
        global $wpdb;
        $rows = $wpdb->get_results( "SELECT id,name,config FROM wp_quform_forms WHERE id=$form" );
        $items = [];
        $items_checkbox = [];
        foreach( $rows as $row ){
            $items[$row->id] = $row->name;
            $items['data'] = maybe_unserialize( base64_decode( trim( $row->config ) ) );
            $pages = [ $items['data'] ][0]['elements'];
            foreach( $pages as $page ){
                $questions = $page['elements'];
                foreach( $questions as $key => $question ){
                    if( 'radio' == $question['type'] ){
                        // print_r('<pre>' . json_encode($question['options'], JSON_PRETTY_PRINT) . '</pre>');
                        $items_checkbox[] = [
                            'label' => $question['label'],
                            'id' => $question['id'],
                            'answers' => $question['options'],
                        ];
                    }
                }
            }
        }
        return $items_checkbox;
    }

    public static function get_forms_list_select(){
        $rows = self::get_forms_list();
        $items = [];
        foreach( $rows as $row ){
            $items[$row->id] = $row->name;
        }
        return $items;
    }
}
