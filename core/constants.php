<?php

/**
 * Declare constants
 *
 * @since Ramp Assessment 0.0.1
 */

define( 'RAMP_ASSESSMENT_VERSION', $config_ramp_assessment['version'] );

define( 'RAMP_ASSESSMENT_SLUG', $config_ramp_assessment['slug'] );

define( 'RAMP_ASSESSMENT_TEXT_DOMAIN', $config_ramp_assessment['text-domain'] );

define( 'RAMP_ASSESSMENT_BASE_NAMESPACE', $config_ramp_assessment['base-namespace'] );

define( 'RAMP_ASSESSMENT_DIR', dirname( dirname( __FILE__ ) ) );

define( 'RAMP_ASSESSMENT_URL', plugins_url( '', dirname( __FILE__ ) ) );

define( 'RAMP_ASSESSMENT_CORE_DIR', trailingslashit( RAMP_ASSESSMENT_DIR ) . $config_ramp_assessment['core-folder'] );

define( 'RAMP_ASSESSMENT_CORE_URL', trailingslashit( RAMP_ASSESSMENT_URL ) . $config_ramp_assessment['core-folder'] );

define( 'RAMP_ASSESSMENT_ASSETS_DIR', trailingslashit( RAMP_ASSESSMENT_DIR ) . $config_ramp_assessment['assets-folder'] );

define( 'RAMP_ASSESSMENT_ASSETS_URL', trailingslashit( RAMP_ASSESSMENT_URL ) . $config_ramp_assessment['assets-folder'] );

define( 'RAMP_ASSESSMENT_LIBS_DIR', trailingslashit( RAMP_ASSESSMENT_DIR ) . $config_ramp_assessment['libs-folder'] );

define( 'RAMP_ASSESSMENT_LIBS_URL', trailingslashit( RAMP_ASSESSMENT_URL ) . $config_ramp_assessment['libs-folder'] );

define( 'RAMP_ASSESSMENT_BASENAME_DIR', trailingslashit( RAMP_ASSESSMENT_DIR ) . $config_ramp_assessment['basename'] );

define( 'RAMP_ASSESSMENT_BASE_PHP_DIR', trailingslashit( RAMP_ASSESSMENT_DIR ) . $config_ramp_assessment['slug'] . ".php" );
