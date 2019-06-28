<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: getStorifyPlugin-routes.php
 * Description: This page contains the routes of this plugin.
 */

/**
 * This function holds the routes handling logic.
 */
function getStorifyOffersPlugin_Routes_func()
{
    $url = $_SERVER['REQUEST_URI'];

    if (isset($url)) {

        /**
         * remove the leading/trailing forward slashes
         *
         * example:
         * input: '/sample/story/hello-world-gs123/'
         * output: 'sample/story/hello-world-gs123'
         *
         */
        $url = trim($url, '/');

        /**
         * create an array of url slug parts
         *
         * example:
         * input: 'sample/story/hello-world-gs123'
         * output: ['sample', 'story', 'hello-world-gs123']
         *
         */
        $urlParts = explode("/", $url);

        /**
         * find the total number of url slug parts
         *
         * example:
         * input: ['sample', 'story', 'hello-world-gs123']
         * output: 3
         *
         */
        $urlPartsArrLen = count($urlParts);

        /**
         * set the $_GET
         *
         * the 2nd last element in the $urlParts is for the page
         */
        switch ($urlParts[$urlPartsArrLen - 2]) {
            /**
             * if requesting a specific page
             */
            case 'page':
                $_GET['gs-page'] = intval($urlParts[$urlPartsArrLen - 1]);

                if ($_GET['gs-page'] < 1) {
                    $_GET['gs-page'] = 1;
                }

                break;
        }

        /**
         * of the first element in the $urlParts matches the page
         */
        // store and offer page
        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        if (is_array($gs_wp_plugin_options_pages)) {
            foreach ($gs_wp_plugin_options_pages as $key => $value) {
                if ($key === 'offer_page' && $value === $urlParts[0]) {
                    if (isset($urlParts[1])) {
                        $_GET['gs-offerid'] = trim($urlParts[1]);
                        break;
                    }
                } else if ($key === 'store_page' && $value === $urlParts[0]) {
                    if (isset($urlParts[1])) {
                        $_GET['gs-storeid'] = trim($urlParts[1]);
                        break;
                    }
                }
            }
        }

    }

}

/**
 * This function will add new route rule.
 *
 * @param string $slug This is the page, post that has the plugin shortcode.
 *                     Example: If page, post URL: https://example.com/helloworld then, slug = helloworld
 * @return bool
 */
function getStorifyOffersPlugin_Routes_AddRouteRule_func($slug)
{
    // plugin routes
    $routes = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES);

    // if routes exists
    if ($routes !== false) {
        $routes = json_decode($routes, true);
    }

    if (!is_array($routes)) {
        $routes = [];
    }

    // if adding a new slug
    if (isset($slug) && is_string($slug)) {

        // if slug not yet added then add it
        if (!in_array($slug, $routes)) {

            array_push($routes, $slug);

        }

        sort($routes);

        // save routes in db
        update_option(
            GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES,
            json_encode($routes)
        );

        getStorifyOffersPlugin_WP_add_rewrite_rule_func();

    } else {

        return false;

    }

    return true;
}

/**
 * This function will remove route rule.
 *
 * @param string $slug This is the page, post that has the plugin shortcode.
 *                     Example: If page, post URL: https://example.com/helloworld then, slug = helloworld
 * @return bool
 */
function getStorifyOffersPlugin_Routes_RemoveRouteRule_func($slug)
{
    // plugin routes
    $routes = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES);

    // if routes exists
    if ($routes !== false) {
        $routes = json_decode($routes, true);
    }

    if (!is_array($routes)) {
        $routes = [];
    }

    // if adding a new slug
    if (isset($slug) && is_string($slug)) {

        // if slug in routes
        if (in_array($slug, $routes)) {

            array_splice($routes, array_search($slug, $routes), 1);

            sort($routes);

            // save routes in db
            update_option(
                GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES,
                json_encode($routes)
            );

            getStorifyOffersPlugin_WP_add_rewrite_rule_func();

        }

    } else {

        return false;

    }

    return true;
}

/**
 * This function will reload route rule.
 */
function getStorifyOffersPlugin_Routes_ReloadRouteRule_func()
{
    getStorifyOffersPlugin_WP_add_rewrite_rule_func();
}

/**
 * This will add the rewrite rule using wp add_rewrite_rule function.
 *
 * @param null|string $route
 */
function getStorifyOffersPlugin_WP_add_rewrite_rule_func($route = null)
{
    // plugin routes
    $routes = get_option(
        GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES
    );

    // if routes exists
    if ($routes !== false) {
        $routes = json_decode($routes, true);
    }

    if (!is_array($routes)) {
        $routes = [];
    }

    // create rewrite rules
    foreach ($routes as $route) {

        /**
         * this will handle the page
         */
        add_rewrite_rule(
            $route . '/page/([0-9]+)/?$',
            'index.php?pagename=' . $route . '&gs-page=$matches[1]',
            'top'
        );

    }


    // store and offer page
    $gs_wp_plugin_options_pages = json_decode(
        get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
        true
    );

    if (is_array($gs_wp_plugin_options_pages)) {
        // create rewrite rules
        foreach ($gs_wp_plugin_options_pages as $key => $value) {

            $route = $value;

            switch ($key) {
                case 'offer_page':
                    /**
                     * this will handle the offerid
                     */
                    add_rewrite_rule(
                        $route . '/([0-9a-zA-Z\_\-]+)/?$',
                        'index.php?pagename=' . $route . '&gs-offerid=$matches[1]',
                        'top'
                    );

                    /**
                     * this will handle the offerid and page
                     */
                    add_rewrite_rule(
                        $route . '/([0-9a-zA-Z\_\-]+)/page/([0-9]+)/?$',
                        'index.php?pagename=' . $route . '&gs-offerid=$matches[1]&gs-page=$matches[2]',
                        'top'
                    );
                    break;

                case 'store_page':
                    /**
                     * this will handle the storeid
                     */
                    add_rewrite_rule(
                        $route . '/([0-9a-zA-Z\_\-]+)/?$',
                        'index.php?pagename=' . $route . '&gs-storeid=$matches[1]',
                        'top'
                    );

                    /**
                     * this will handle the storeid and page
                     */
                    add_rewrite_rule(
                        $route . '/([0-9a-zA-Z\_\-]+)/page/([0-9]+)/?$',
                        'index.php?pagename=' . $route . '&gs-storeid=$matches[1]&gs-page=$matches[2]',
                        'top'
                    );
                    break;
            }
        }
    }
}

/**
 * This function will return the list of routes slug added by the user.
 *
 * @return string
 */
function getStorifyOffersPlugin_List_AddedRoutes_func()
{
    // plugin routes
    $routes = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_ROUTES);

    // if routes exists
    if ($routes !== false) {
        $routes = json_decode($routes, true);
    }

    if (!is_array($routes)) {
        $routes = [];
    }

    $siteurl = get_site_url();

    // create routes list
    $html = "";
    foreach ($routes as $route) {

        $href = $siteurl . "/" . $route;

        $html .= <<<HTML
<span style="padding: 10px; display: inline-block; margin-right: 15px; margin-bottom: 15px; font-size: 18px; border: 1px solid #87cefa; border-left: 5px solid #87cefa;">
<a href="{$href}">{$route}</a>
</span>
HTML;
    }

    return $html;

}
