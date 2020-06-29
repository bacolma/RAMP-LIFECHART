<?php namespace RampAssessment\Core;

/**
 * Class Functions for help
 *
 * @since Ramp Assessment 0.0.1
 */
class Functions {
    public static function includes_url( $path = '' ){
        return RAMP_ASSESSMENT_URL . '/includes' . $path;
    }

    public static function includes_dir( $path = '' ){
        return RAMP_ASSESSMENT_DIR . '/includes' . $path;
    }

    public static function assets_url( $path = '' ){
        return RAMP_ASSESSMENT_URL . '/assets' . $path;
    }

    public static function assets_dir( $path = '' ){
        return RAMP_ASSESSMENT_DIR . '/assets' . $path;
    }

    public static function core_dir( $path = '' ){
        return RAMP_ASSESSMENT_DIR . '/core' . $path;
    }

    public static function libs_url( $path = '' ){
        return RAMP_ASSESSMENT_LIBS_URL . $path;
    }

    public static function libs_dir( $path = '' ){
        return RAMP_ASSESSMENT_DIR . '/libs' . $path;
    }

    /**
     * Get if plugin is active
     *
     * @param mixed $plugin_name
     *
     * @return bool
     * @since Ramp Assessment 0.0.3
     */
    public static function is_active_plugin_by_name( $plugin_name ){
        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
        $active = false;
        foreach( $active_plugins as $plugin ){
            if( strpos( $plugin, $plugin_name ) ){
                $active = true;
            }
        }
        return $active;
    }

    public static function super_unique( $array ){
        $result = array_map( "unserialize", array_unique( array_map( "serialize", $array ) ) );

        foreach( $result as $key => $value ){
            if( is_array( $value ) ){
                $result[$key] = self::super_unique( $value );
            }
        }

        return $result;
    }
}
