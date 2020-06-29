<?php namespace RampAssessment\Core;

/**
 * Main class RampAssessment
 *
 * @since Ramp assessment 0.0.1
 */
class RampAssessment {
    /**
     * @var array $config_ramp_assessment Base configuration array
     * @since Ramp assessment 0.0.1
     */
    private $config_ramp_assessment;

    /**
     * RampAssessment constructor.
     *
     * @param array $config_ramp_assessment Base configuration array
     *
     * @since Ramp assessment 0.0.1
     */
    public function __construct( $config_ramp_assessment ){
        $this->config_ramp_assessment = $config_ramp_assessment;
        $this->init_auto_update();
        $this->hooks();
        $this->load_classes();
    }

    /**
     * Load instances of api and assets
     *
     * @since Ramp assessment 0.0.1
     */
    public function load_classes(){
        new AssetsLoader( $this->config_ramp_assessment['version'] );
    }

    /**
     * Base for auto update plugin functionality
     *
     * @since Ramp assessment 0.0.1
     */
    public function init_auto_update(){
        /*
            $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
            'http://wpbot_dialogflowplugin.xyz/updates/?action=get_metadata&slug=wpbot_dialogflow',
            IHO_DEVCORT_BASE_PHP_DIR,
            $this->>config_ramp_assessment['slug']
            );
         */
    }

    /**
     * Load hooks
     *
     * @since Ramp assessment 0.0.1
     */
    public function hooks(){
        add_action( 'xbox_init', [ $this, 'create_metabox' ], 100 );
        add_action( 'xbox_init', [ $this, 'create_metabox_ramp_assessment_post_type' ] );
        add_filter( 'the_content', [ $this, 'content_ramp_assessment' ] );
        add_filter( 'the_content', [ $this, 'content_ramp_assessment_list' ] );
        add_filter( 'wp', [ $this, 'register_process_ramp_assessment_form' ] );
        add_action( 'init', [ $this, 'ramp_assessment_post_type' ] );
    }

    /**
     * Create custom post type "Assessment"
     *
     * @since Ramp assessment 0.0.1
     */

    public function ramp_assessment_post_type(){
        // Set UI labels for Custom Post Type
        $labels = array(
            'name' => _x( 'Assessments', 'Post Type General Name', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'singular_name' => _x( 'Assessment', 'Post Type Singular Name', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'menu_name' => __( 'Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'parent_item_colon' => __( 'Parent Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'all_items' => __( 'All assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'view_item' => __( 'View Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'add_new_item' => __( 'Add New Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'add_new' => __( 'Add New', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'edit_item' => __( 'Edit Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'update_item' => __( 'Update Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'search_items' => __( 'Search Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'not_found' => __( 'Not Found', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'not_found_in_trash' => __( 'Not found in Trash', RAMP_ASSESSMENT_TEXT_DOMAIN ),
        );

        // Set other options for Custom Post Type

        $args = array(
            'label' => __( 'ramp_assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'description' => __( 'Assessment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'labels' => $labels,
            // Features this CPT supports in Post Editor
            'supports' => array( 'title', 'thumbnail' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_rest' => false,
            'rewrite' => array(
                'slug' => 'assessment',
                'with_front' => false
            ),
        );
        // flush_rewrite_rules(); // For clear rules
        register_post_type( 'ramp_assessment', $args );
    }

    /**
     * Get last complete date of form of symptom diary
     *
     * @param $users_responses
     * @param $page_id
     *
     * @return string
     * @since Ramp assessment 0.0.2
     */

    private function get_last_completed_date_of_form( $users_responses, $page_id ){
        $date = '--';
        if( isset( $users_responses[$page_id] ) ){
            $forms = $users_responses[$page_id];
            if( is_array( $forms ) ){
                $last_response = '--';
                foreach( $forms as $form ){
                    $count = 0;
                    $sizeResponses = count( $form['responses'] );
                    foreach( $form['responses'] as $date => $response ){
                        $count += 1;
                        if( $count == $sizeResponses ){
                            $last_response = $date;
                        }
                    }
                }
                if( $last_response != '--' ){
                    date_default_timezone_set( 'America/Vancouver' );
                    $date = date_create_from_format( 'm-d-Y', $last_response )->format( 'M/d/Y' );
                }
            }
        }
        return $date;
    }

    /**
     *
     * Return assessment
     *
     * @param $content
     *
     * @return mixed
     * @since Ramp assessment 0.0.1
     */
    public function content_ramp_assessment_list( $content ){
        if( ! is_page() || ! is_user_logged_in() ){
            return $content;
        }

        $xbox_metabox = \xbox_get( 'ramp_assessment_list_page' );
        $page_id = get_queried_object_id();

        $has_daily_form = $xbox_metabox->get_field_value( "assessment-active", $page_id, 'no' );
        if( $has_daily_form == 'yes' ){
            $ramp_assessment_list = get_posts( array(
                'fields' => [ 'ids', 'post_title' ],
                'posts_per_page' => -1,
                'post_type' => 'ramp_assessment',
                'order' => 'ASC',
            ) );
            $xbox = \xbox_get( 'ramp_assessment' );
            $ramp_assessment = [];
            $user_id = get_current_user_id();
            $groups = learndash_get_users_group_ids( $user_id );
            date_default_timezone_set( 'America/Vancouver' );
            if( sizeof( $groups ) != 0 ){
                $first_group = $groups[0];
                $user_responses = get_user_meta( $user_id, 'ramp_assessment', true );
                $user_responses_serialized = maybe_unserialize( $user_responses );
                foreach( $ramp_assessment_list as $key => $diary ){
                    $position = $xbox->get_field_value( 'position', $diary->ID, $key );
                    $student_groups = $xbox->get_field_value( 'student-group', $diary->ID, [] );
                    if( array_search( $first_group, $student_groups ) !== false ){
                        $ramp_assessment[$position]['post'] = $diary;
                        $ramp_assessment[$position]['date'] = $this->get_last_completed_date_of_form( $user_responses_serialized, $diary->ID );
                    }
                }
                ksort( $ramp_assessment );
                include_once 'html_includes/ramp_assessment_list.php';
            }
        }
        return $content;
    }

    /**
     * Render Assessment Detail Page
     *
     * @param $content
     *
     * @return mixed
     * @since Ramp assessment 0.0.1
     */

    public function content_ramp_assessment( $content ){
        if( ! is_single() || ! is_singular() ){
            return $content;
        }

        $page_id = get_queried_object_id();
        $xbox = \xbox_get( 'ramp_assessment' );
        $student_groups = $xbox->get_field_value( 'student-group', $page_id, [] );
        $user_id = get_current_user_id();
        $groups = learndash_get_users_group_ids( $user_id );
        if( sizeof( $groups ) != 0 ){
            $group = $groups[0];
            if( array_search( $group, $student_groups ) !== false ){
                $form_id = $xbox->get_field_value( 'form', $page_id, [] );
                $charts = $xbox->get_field_value( "charts-$form_id", $page_id, [] );
                $charts_data = [];
                foreach( $charts as $chart ){
                    $options = isset( $chart["options-$form_id"] ) ? $chart["options-$form_id"] : '';
                    $options_list = isset( $chart["list-$form_id-$options"] ) ? $chart["list-$form_id-$options"] : [];
                    $options_data = [];
                    foreach( $options_list as $option ){
                        $data = explode( '____', $option );
                        $options_data[$data[0]] = $data[1];
                    }
                    $charts_data[] = [
                        'type' => isset( $chart['chart-type'] ) ? $chart['chart-type'] : 'pie',
                        'title' => isset( $chart['title'] ) ? $chart['title'] : '',
                        'options_list' => $options_data,
                        'legend' => isset( $chart['legend'] ) ? $chart['legend'] : 'no',
                        'questions' => isset( $chart["question-$form_id"] ) ? $chart["question-$form_id"] : []
                    ];
                }
                date_default_timezone_set( 'America/Vancouver' );
                $current_date = date( 'm-d-Y', time() );
                $user_responses = get_user_meta( $user_id, 'ramp_assessment', true );
                $user_responses_serialized = maybe_unserialize( $user_responses );
                $has_response_today = isset( $user_responses_serialized[$page_id][$form_id]['responses'][$current_date] );

                if( ! $has_response_today && $_GET['start'] == 'now' ){
                    include_once 'html_includes/symptom_diary/symptom_diary_form.php';
                } else{
                    $description = $xbox->get_field_value( 'description', $diary->ID, '' );
                    $data_forms = QuestionnairePage::get_questions_and_options_of_forms( true );
                    if( isset( $user_responses_serialized[$page_id][$form_id] ) ){
                        $response_json = isset( $user_responses_serialized[$page_id][$form_id] ) ? json_encode( $user_responses_serialized[$page_id][$form_id] ) : '{}';
                        $charts_json = json_encode( $charts_data );
                        $data_forms_json = json_encode( $data_forms[$form_id] );
                    }
                    include_once 'html_includes/symptom_diary/symptom_diary_resume.php';
                }
            }
        }
        return $content;
    }

    /**
     * Register filter process form of symptom diary form
     *
     * @since Ramp assessment 0.0.1
     */

    public function register_process_ramp_assessment_form(){
        if( ! is_single() || ! is_singular() ){
            return;
        }
        $page_id = get_queried_object_id();
        $xbox = \xbox_get( 'ramp_assessment' );
        $student_groups = $xbox->get_field_value( 'student-group', $page_id, [] );
        $user_id = get_current_user_id();
        $groups = learndash_get_users_group_ids( $user_id );
        if( sizeof( $groups ) != 0 ){
            $group = $groups[0];
            if( array_search( $group, $student_groups ) !== false ){
                $form_id = $xbox->get_field_value( 'form', $page_id, [] );
                add_filter( "quform_post_process_$form_id", [ $this, 'process_assessment' ], 10, 2 );
            }
        }
    }

    /**
     * Process form of symptom diary
     *
     * @param array $result
     * @param \Quform_Form $form
     *
     * @since Ramp assessment 0.0.1
     */

    public function process_assessment( array $result, \Quform_Form $form ){
        $user = wp_get_current_user();
        $form_values = $form->getValues();
        $options = [];
        date_default_timezone_set( 'America/Vancouver' );
        $current_date = date( 'm-d-Y', time() );
        $response = [];
        $question_considerate = [];
        $groups = learndash_get_users_group_ids( get_current_user_id() );
        $user_responses = get_user_meta( $user->ID, 'ramp_assessment', true );
        $user_responses_serialized = maybe_unserialize( $user_responses );
        $page_id = get_queried_object_id();
        $xbox = \xbox_get( 'ramp_assessment' );
        $student_groups = $xbox->get_field_value( 'student-group', $page_id, [] );

        $form_id = $form->getId();
        if( sizeof( $groups ) != 0 ){
            $group = $groups[0];
            if( array_search( $group, $student_groups ) !== false ){
                foreach( $form_values as $key => $value ){
                    $response[$key] = $value;
                }
            }
        }
        // 1 . Existe el indice con el id de formulario?
        if( ! isset( $user_responses_serialized[$page_id] ) || $user_responses_serialized == '' ){
            $user_data[$page_id] = [
                "{$form_id}" => [
                    'responses' => [
                        "$current_date" => $response
                    ],
                ]
            ];
            update_user_meta( $user->ID, 'ramp_assessment', serialize( $user_data ) );
        } else{
            // El formulario existe y verificar que en los resposne no exista un key con la fecha actual
            if( ! isset( $user_responses_serialized[$page_id][$form_id]['responses'][$current_date] ) ){
                $user_responses_serialized[$page_id][$form_id]['responses'][$current_date] = $response;
                update_user_meta( $user->ID, 'ramp_assessment', serialize( $user_responses_serialized ) );
            }
        }
        $page_id = get_queried_object_id();
        $url = get_permalink( $page_id );
        echo "<script>window.location.replace('$url');</script>";
    }

    /**
     * Crate page of options for create logic questions in web hook dialogflow
     *
     * @since    Input Health options 0.0.4
     */
    public function create_metabox_ramp_assessment_post_type(){
        $options = [
            'id' => 'ramp_assessment',
            'title' => __( 'Assesment', RAMP_ASSESSMENT_TEXT_DOMAIN ),
            'skin' => 'teal',
            'post_types' => [ 'ramp_assessment' ],
            'footer' => 'Input Health options v' . RAMP_DAILY_FORMS_VERSION,
        ];
        $xbox = xbox_new_metabox( $options );
        include dirname( __FILE__ ) . '/fields/ramp_assessment_page.php';
    }

    /**
     * Crate metabox of daily form for pages
     *
     * @since    Input Health options 0.0.4
     */

    public function create_metabox(){
        // METABOX TASKS
        $options = [
            'id' => 'ramp_assessment_list_page',
            'title' => 'Assesment',
            'skin' => 'teal',
            'post_types' => [ 'page' ],
        ];
        $xbox = xbox_new_metabox( $options );
        include dirname( __FILE__ ) . '/fields/ramp_assessment_metabox_options.php';
    }
}
