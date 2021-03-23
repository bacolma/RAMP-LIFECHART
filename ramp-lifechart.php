<?php
/*
Plugin Name: Ramp lifechart
Description: Ramp lifechart
Author: 4abyte Inc and devcort
Version: 0.0.2
 */

if( ! defined( 'ABSPATH' ) || ! defined( 'WPINC' ) ){
    exit;
}
/**
 * Base configuration for lifechart
 *
 * @var array $config_ramp_lifechart
 * @since Ramp assessment 0.0.2
 */

$config_ramp_lifechart = [
    "version" => "0.0.1",
    "basename" => "ramp_lifechart",
    "base-namespace" => "RampLifechart",
    "plugin-name" => "Ramp lifechart",
    "text-domain" => 'ramp_lifechart',
    'slug' => 'ramp_lifechart',
    'core-folder' => 'core',
    'libs-folder' => 'libs',
    'assets-folder' => 'assets',
    'php-version-required' => '7.1',
];

/**
 * Ramp lifechart constants
 *
 * @since Ramp Lifechart 0.0.1
 */

require_once dirname( __FILE__ ) . '/' . $config_ramp_lifechart['core-folder'] . '/constants.php';

/**
 * Ramp lifechart autoload class
 *
 * @since Ramp lifechart 0.0.1
 */

require_once dirname( __FILE__ ) . '/' . $config_ramp_lifechart['core-folder'] . '/autoload.class.php';

/**
 * Include Xbox Framewotk Library
 *
 * @author CodexHelp | https://codecanyon.net/user/codexhelp
 * @link   https://codecanyon.net/item/xbox-framework-create-meta-boxes-theme-options-admin-pages-for-wordpress/19250995
 */
//include dirname( __FILE__ ) . '/libs/xbox/xbox.php';

/**
 * Call to run function of autoload class
 *
 * @param array $config_ramp_lifechart Base configuration array
 *
 * @since Ramp lifechart 0.0.1
 */

RampLifechart\Core\Autoload::run( $config_ramp_lifechart );

/**
 * * Create instance of that RampLifechart
 *
 * @param array $config_ramp_lifechart Base configuration array
 *
 * @since Ramp lifechart 0.0.1
 */
$ramp_lifechart = new RampLifechart\Core\RampLifechart( $config_ramp_lifechart );
