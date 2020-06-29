<?php namespace RampAssessment\Core;

/**
 * Class AssetsLoader
 *
 * @package RampAssessment\Core
 * @since   Ramp assesment 0.0.1
 */
class AssetsLoader {
    /**
     * @var string Current version of Wpbot Dialogflow Addon
     * @since Ramp assesment 0.0.1
     */
    public $version;
    /**
     * Verify if js assets is loaded
     *
     * @var bool
     * @since Ramp assesment 0.0.1
     */
    public $js_loaded = false;
    /**
     * Verify if css assets is loaded
     *
     * @var bool
     * @since Ramp assesment 0.0.1
     */
    public $css_loaded = false;

    /**
     * AssetsLoader constructor.
     *
     * Add action of enqueue scripts to wordpress
     *
     * @param string $version Current version of Wpbot Dialogflow Addon
     *
     * @since Ramp assesment 0.0.1
     */
    public function __construct( $version ){
        $this->version = $version;
        add_action( 'admin_enqueue_scripts', [ $this, 'load_assets' ], 10, 1 );
        add_action( 'wp_enqueue_scripts', [ $this, 'load_public_assets' ] );
    }

    /**
     * Load js and css style depend of the hook
     *
     * @param $hook
     *
     * @uses  add_action()
     * @since Ramp assesment 0.0.1
     */
    public function load_assets( $hook ){
        if( false === stripos( $hook, 'toplevel_page_wplivechat-menu' ) ){
            return;
        }
        $this->load_scripts();
        $this->load_styles();
    }

    /**
     * Register js scripts in enqueue of wordpress register
     *
     * @since Ramp assesment 0.0.1
     */
    private function load_scripts(){
        if( $this->js_loaded ){
            return;
        }

        wp_register_script( 'ramp_assessment_script_admin', Functions::assets_url( '/admin/js/index.js' ), [], $this->version, true );
        wp_enqueue_script( 'ramp_assessment_script_admin' );
        wp_localize_script( 'ramp_assessment_script_admin', 'RAMP_ASSESSMENT', $this->localization() );
        $this->js_loaded = true;
    }

    /**
     * Register css styles in enqueue of wordpress register
     *
     * @since Ramp assesment 0.0.1
     */
    private function load_styles(){
        if( $this->css_loaded ){
            return;
        }

        wp_register_style( 'ramp_assessment_style_admin', Functions::assets_url( '/admin/dist/css/style.css' ), [], $this->version );
        wp_enqueue_style( 'ramp_assessment_style_admin' );
        $this->css_loaded = true;
    }

    /**
     * Register public assets in enqueue of wordpress register
     *
     * @since Ramp assesment 0.0.2
     */
    public function load_public_assets(){
        /**
         * Styles
         */
        wp_enqueue_style( 'ramp_assessment_style_public', Functions::assets_url( '/public/dist/css/style.css' ), [], $this->version );
        // wp_enqueue_script( 'ramp_assessment_style_script_public', Functions::assets_url( '/public/dist/css/style.js' ), [], $this->version ); // In development

        /**
         * Scripts
         */
        wp_enqueue_script( 'ramp_assessment_script_public', Functions::assets_url( '/public/dist/js/index.js' ), [], $this->version );
        wp_localize_script( 'ramp_assessment_script_public', 'RAMP_ASSESSMENT', $this->localization() );

        /**
         * Libs
         */
        wp_enqueue_style( 'ramp_assessment_style_pickadate_default_public', Functions::assets_url( '/public/libs/pickadate/default.css' ), [], $this->version );
        wp_enqueue_style( 'ramp_assessment_style_pickadate_default_date_public', Functions::assets_url( '/public/libs/pickadate/default.date.css' ), [], $this->version );
        wp_enqueue_style( 'ramp_assessment_style_range_slider_public', Functions::assets_url( '/public/libs/rangeslider.css' ), [], $this->version );
        wp_enqueue_script( 'ramp_assessment_script_range_slider_public', Functions::assets_url( '/public/libs/rangeslider.min.js' ), [], $this->version );
        wp_enqueue_script( 'ramp_assessment_script_pickadate_default_public', Functions::assets_url( '/public/libs/pickadate/picker.js' ), [], $this->version );
        wp_enqueue_script( 'ramp_assessment_script_pickadate_date_public', Functions::assets_url( '/public/libs/pickadate/picker.date.js' ), [], $this->version );
    }

    /**
     * Load localization values
     *
     * @return array ajax_url - Admin ajax url, ajax_nonce - Nonce for ajax requests
     * @since    Ramp assesment 0.0.1
     */
    public function localization(){
        return [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'public_assets_url' => Functions::assets_url(),
            'ajax_nonce' => wp_create_nonce( 'ramp_assessment_ajax_nonce' ),
        ];
    }
}