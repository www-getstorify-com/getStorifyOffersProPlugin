<?php
/**
 * @package getStorifyOffersProPlugin
 */

/*
Plugin Name: getStorify Offers Pro Plugin
Plugin URI: https://getstorify.com
Description: This is the getStorify Offers Pro Plugin for WordPress. Use this to show your stores and offers in your WordPress website.
Version: 1.0.0
Author: getStorify
Author URI: https://getstorify.com
License: MIT License
Text domain: getStorify Offers Pro Plugin
*/

// to avoid direct access
defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/app/config/constants.php';
require_once __DIR__ . '/app/getStorifyPlugin-routes.php';

/**
 * ====================================================================
 * getStorify Offer Plugin - reload route rules if they exists
 *
 * check the app/getStorifyPlugin-routes.php file for the
 * getStorifyOffersPlugin_Routes_ReloadRouteRule_func() function.
 *
 */
add_action('init', 'getStorifyOffersPlugin_Routes_ReloadRouteRule_func');
//========= getStorify Offer Plugin add rewrite rule ends here ==========

/**
 * ====================================================================
 * getStorify Offer Plugin activation code
 */
function getStorifyOffersPlugin_pluginActivate_func()
{
    add_option('getStorifyOffersPlugin_Activated_Plugin', 'getStorifyOffersPlugin_Activated');
}

register_activation_hook(__FILE__, 'getStorifyOffersPlugin_pluginActivate_func');

//========= getStorify Offer Plugin activation code ends here ===========


/**
 * ====================================================================
 * Add getStorify Offer Plugin to admin_menu
 */
function getStorifyOffersPluginSetupPageHTML_func()
{
    require_once __DIR__ . '/app/view/page/wp-setup-page.php';
}

function getStorifyOffersPlugin_AdminMenuAction_func()
{
    add_options_page("getStorify Offers Pro Plugin", "getStorify Offers Pro Plugin", 1, "getStorifyOffersProPlugin", "getStorifyOffersPluginSetupPageHTML_func");

    /* do stuff once right after activation */
    if (get_option('getStorifyOffersPlugin_Activated_Plugin') == 'getStorifyOffersPlugin_Activated') {

        delete_option('getStorifyOffersPlugin_Activated_Plugin');

        // if router options does not exists then create it
        if (!get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES)) {
            update_option(
                GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES,
                ''
            );
        }

        // set the shortcode
        update_option(
            GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE,
            GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE
        );

        // reload routes
        getStorifyOffersPlugin_Routes_ReloadRouteRule_func();

    }
}

add_action('admin_menu', 'getStorifyOffersPlugin_AdminMenuAction_func');

//========= add getStorify Offer Plugin to admin_menu ends here ========


/**
 * ====================================================================
 * Add getStorify Offer Plugin shortcode
 */
function getStorifyOffersPlugin_ShortCode_func($atts = [])
{
    // load and handle the routes
    require_once __DIR__ . '/app/getStorifyPlugin-routes.php';
    getStorifyOffersPlugin_Routes_func();

    // save the shortcode attributes
    $GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS] = $atts;

    // require the shortcode
    require_once __DIR__ . '/app/wp-shortcode.php';

    echo getStorifyOffersPlugin_ShortCode_getResultHTML_func();
}

add_shortcode(get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE), 'getStorifyOffersPlugin_ShortCode_func');

//========= add getStorify Offer Plugin shortcode ends here ========

