<?php
/*
Plugin Name: WP Track Keeper
Plugin URI: mrparagon.me/wp-track-keeper/
Description: Keep track of your wordpress files and get instant alert when any files changes 
Author: Kingsley Paragon
Version: 1.0
Requires at least: 3.5
Requires PHP: 5.6
Tested up to: 5.2.3
Author URI: mrparagon.me
license: GPLV2
Text Domain: wp-track-keeper
Domain Path: /langs/
*/



if (!defined('ABSPATH')) {
    exit;
}

function activate()
{
    require_once plugin_dir_path(__FILE__).'/inc/TKActivation.php';
    TKActivation::run();
}

function deactivate()
{
    require_once plugin_dir_path(__FILE__).'/inc/TKDeactivation.php';
    TKDeactivation::run();
}

register_activation_hook(__FILE__, 'activate');
register_deactivation_hook(__FILE__, 'deactivate');

/**
 * Let's Do it.
 */
require_once plugin_dir_path(__FILE__).'/inc/TrackKeeper.php';
new TrackKeeper();