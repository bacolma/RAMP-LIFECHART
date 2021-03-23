<?php namespace RampLifechart\Core;

/**
 * Class AssetsLoader
 *
 * @package RampAssessment\Core
 * @since   Ramp assesment 0.0.1
 */
/**
 * Main class Others
 *
 * @since Input Health Options 0.0.1
 */
class RampLifechart {
    private $version = null;

    /**
     * Others constructor.
     *
     * @param string $version
     *
     * @since Input Health Options 0.0.1
     */
    public function __construct(){
           $this->hooks();
    }

  
    public function hooks(){ 
        add_shortcode( 'lifechart', [ $this, 'lifechart' ] );
     }

    public function lifechart(){
        include_once 'html_includes/ramp_lifechart_list.php';       
     }      


    
}