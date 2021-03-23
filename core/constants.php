<?php

/**
 * Declare constants
 *
 * @since Ramp Lifechart 0.0.1
 */

define( 'RAMP_LIFECHART_VERSION', $config_ramp_lifechart['version'] );

define( 'RAMP_LIFECHART_SLUG', $config_ramp_lifechart['slug'] );

define( 'RAMP_LIFECHART_TEXT_DOMAIN', $config_ramp_lifechart['text-domain'] );

define( 'RAMP_LIFECHART_BASE_NAMESPACE', $config_ramp_lifechart['base-namespace'] );

define( 'RAMP_LIFECHART_DIR', dirname( dirname( __FILE__ ) ) );

define( 'RAMP_LIFECHART_URL', plugins_url( '', dirname( __FILE__ ) ) );

define( 'RAMP_LIFECHART_CORE_DIR', trailingslashit( RAMP_LIFECHART_DIR ) . $config_ramp_lifechart['core-folder'] );

define( 'RAMP_LIFECHART_CORE_URL', trailingslashit( RAMP_LIFECHART_URL ) . $config_ramp_lifechart['core-folder'] );

define( 'RAMP_LIFECHART_ASSETS_DIR', trailingslashit( RAMP_LIFECHART_DIR ) . $config_ramp_lifechart['assets-folder'] );

define( 'RAMP_LIFECHART_ASSETS_URL', trailingslashit( RAMP_LIFECHART_URL ) . $config_ramp_lifechart['assets-folder'] );

define( 'RAMP_LIFECHART_LIBS_DIR', trailingslashit( RAMP_LIFECHART_DIR ) . $config_ramp_lifechart['libs-folder'] );

define( 'RAMP_LIFECHART_LIBS_URL', trailingslashit( RAMP_LIFECHART_URL ) . $config_ramp_lifechart['libs-folder'] );

define( 'RAMP_LIFECHART_BASENAME_DIR', trailingslashit( RAMP_LIFECHART_DIR ) . $config_ramp_lifechart['basename'] );

define( 'RAMP_LIFECHART_BASE_PHP_DIR', trailingslashit( RAMP_LIFECHART_DIR ) . $config_ramp_lifechart['slug'] . ".php" );
