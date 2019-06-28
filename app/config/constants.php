<?php
/**
 * Author: Yusuf Shakeel
 * Date: 17-jun-2019 Mon
 * Version: 1.0
 *
 * File: constants.php
 * Description: This page contains constants.
 */

define('GETSTORIFY_OFFERS_PLUGIN_WP_SITE_URL', get_home_url());
define('GETSTORIFY_OFFERS_PLUGIN_DIR', 'getStorifyOffersProPlugin');
define('GETSTORIFY_OFFERS_PLUGIN_DIR_URL', GETSTORIFY_OFFERS_PLUGIN_WP_SITE_URL . '/wp-content/plugins/' . GETSTORIFY_OFFERS_PLUGIN_DIR);

// for wordpress version 5.0+
define('GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE', 'getstorifyoffersplugin_shortcode');

define('GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS', 'getStorifyOffersPlugin_ShortCode_Params');

// WP_OPTIONS Name
// this goes inside the wp_options table
// and represents the value of the option_name column of the table
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_SHORTCODE', 'getStorifyOffersPluginOptions_shortcode');
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES', 'getStorifyOffersPluginOptions_routes');
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES', 'getStorifyOffersPluginOptions_pages');
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_USER_ID', 'getStorifyOffersPluginOptions_user_id');
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_ID', 'getStorifyOffersPluginOptions_app_id');
define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_TOKEN', 'getStorifyOffersPluginOptions_app_token');

define('GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_GOOGLE_API_KEY_WEB_KEY', 'getStorifyOffersPluginOptions_googleApiKey');

define('GETSTORIFY_OFFERS_PLUGIN_USER_DEFAULT_PROFILE_IMAGE', 'https://getstorify.com/storify/image/user/default-1.png');

define('GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT', 10);