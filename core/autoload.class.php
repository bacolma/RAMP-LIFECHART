<?php namespace RampLifechart\Core;

/**
 *  Class Autoload
 *
 * @since Ramp assessment 0.0.1
 */
class Autoload {
    /**
     * @var string $namespace_separator Separator of namespace
     * @since Ramp assessment 0.0.1
     */
    private $namespace_separator = '\\';
    /**
     * @var string $extension Extension of classes files
     * @since Ramp assessment 0.0.1
     */
    private $extension = '.class.php';
    /**
     * @var null $file File of class to include
     * @since Ramp assessment 0.0.1
     */
    private $file = null;
    /**
     * @var string $plugin_base_namespace
     * @since Ramp assessment 0.0.1
     */
    private static $plugin_base_namespace = "";

    /**
     * Run spl autoload register classes
     *
     * @param array $config_iho_devcort Base configuration for Wpbot Dialogflow Addon
     *
     * @since Ramp assessment 0.0.1
     */
    public static function run( $config_iho_devcort ){
        self::$plugin_base_namespace = $config_iho_devcort['base-namespace'];
        spl_autoload_register( [ new self, 'load_plugin_class' ] );
    }

    /**
     * Require class if exist in Wpbot Dialogflow Addon
     *
     * @param Class $class A class to include
     *
     * @since Ramp assessment 0.0.1
     */
    private function load_plugin_class( $class ){
        $full_path = plugin_dir_path( dirname( __FILE__ ) );
        $class = trim( $class, $this->namespace_separator );
        if( strpos( $class, self::$plugin_base_namespace ) === false ){
            return;
        }
        $pos_end_slash = strripos( $class, $this->namespace_separator );
        $paths = explode( $this->namespace_separator, $class );
        $class_name = ltrim( strtolower( preg_replace( '/[A-Z]/', '-$0', end( $paths ) ) ), '-' );
        array_shift( $paths );
        array_pop( $paths );
        foreach( $paths as $path ){
            $full_path .= ltrim( strtolower( preg_replace( '/[A-Z]/', '_$0', $path ) ), '_' ) . DIRECTORY_SEPARATOR;
        }
        $this->file = $full_path . $class_name . $this->extension;
        if( file_exists( $this->file ) ){
            require_once $this->file;
        }
    }
}
