<?php
/*
Plugin Name: Ramp assessment
Description: Ramp assessment
Author: 4abyte Inc and devcort
Version: 0.0.2
 */

if( ! defined( 'ABSPATH' ) || ! defined( 'WPINC' ) ){
    exit;
}
/**
 * Base configuration for ramp_assessment
 *
 * @var array $config_ramp_assessment
 * @since Ramp assessment 0.0.2
 */

$config_ramp_assessment = [
    "version" => "0.0.2",
    "basename" => "ramp_assessment",
    "base-namespace" => "RampAssessment",
    "plugin-name" => "Ramp assessment",
    "text-domain" => 'ramp_assessment',
    'slug' => 'ramp_assessment',
    'core-folder' => 'core',
    'libs-folder' => 'libs',
    'assets-folder' => 'assets',
    'php-version-required' => '7.1',
];

/**
 * Ramp assessment constants
 *
 * @since Ramp assessment 0.0.1
 */

require_once dirname( __FILE__ ) . '/' . $config_ramp_assessment['core-folder'] . '/constants.php';

/**
 * Ramp assessment autoload class
 *
 * @since Ramp assessment 0.0.1
 */

require_once dirname( __FILE__ ) . '/' . $config_ramp_assessment['core-folder'] . '/autoload.class.php';

/**
 * Include Xbox Framewotk Library
 *
 * @author CodexHelp | https://codecanyon.net/user/codexhelp
 * @link   https://codecanyon.net/item/xbox-framework-create-meta-boxes-theme-options-admin-pages-for-wordpress/19250995
 */
include dirname( __FILE__ ) . '/libs/xbox/xbox.php';

/**
 * Call to run function of autoload class
 *
 * @param array $config_ramp_assessment Base configuration array
 *
 * @since Ramp assessment 0.0.1
 */

RampAssessment\Core\Autoload::run( $config_ramp_assessment );

/**
 * * Create instance of that RampAssessment
 *
 * @param array $config_ramp_assessment Base configuration array
 *
 * @since Ramp assessment 0.0.1
 */
$ramp_assessment = new RampAssessment\Core\RampAssessment( $config_ramp_assessment );
