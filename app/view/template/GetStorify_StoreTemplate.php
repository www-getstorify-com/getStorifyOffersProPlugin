<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019
 * Version: 1.0
 *
 * File: GetStorify_StoreTemplate.php
 * Description: This file contains store templates.
 */

require_once __DIR__ . '/../../config/constants.php';

class GetStorify_StoreTemplate
{
    /**
     * This will return cards of all the stores.
     *
     * @param array $data
     * @return string
     */
    public static function getStores_MDB($data)
    {
        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        $html = "";

        foreach ($data as $store) {

            $storePageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['store_page'] . '/' . $store['storeid'];

            $storeName = isset($store['storename']) ? trim($store['storename']) : '';

            $storeDescription = isset($store['storedescription']) ? trim($store['storedescription']) : '';
            if (strlen($storeDescription) > 100) {
                $storeDescription = substr($storeDescription, 0, 99) + '...';
            }

            $contactPhone = '';
            if (isset($store['contactphone'])) {

                $contactPhoneNo = trim($store['contactphone']);
                if ($contactPhoneNo[0] !== '+') {
                    $contactPhoneNo = '+' . $contactPhoneNo;
                }

                $contactPhone = <<<HTML
<p class="gtst-store-contact-phone"><i class="fa fa-phone"></i> {$contactPhoneNo}</p>
HTML;

            }

            $storeCoverImage = '';
            if (isset($store['storecover']) && isset($store['storecoverthumbnail'])) {
                $storeCoverImage = <<<HTML
<a class="gtst-store-view-store-link" href="{$storePageLink}"><img src="{$store['storecoverthumbnail']}" data-src="{$store['storecover']}" class="gtst-store-cover-img"></a>
HTML;
            }

            $googleMap_Store = '';
            if (isset($store['latitude']) && isset($store['longitude'])) {
                $mapLoc = "https://maps.google.com/?q=" . $store['latitude'] . ',' . $store['longitude'];
                $googleMap_Store = <<<HTML
<span class="gtst-store-icon map-marker"><a class="gtst-store-view-offer-store-location" href="{$mapLoc}"><i class="fa fa-map-marker"></i></a></span>
HTML;

            }

            $address_cityLocation = '';
            if (isset($store['city_location'])) {
                $address_cityLocation = trim($store['city_location']);
            }

            $address_city = '';
            if (isset($store['city'])) {
                $address_city = trim($store['city']);
            }

            $store_city_and_city_loc = '';
            if (strlen($address_city) > 0) {
                $store_city_and_city_loc .= $address_city;
            }
            if (strlen($address_cityLocation) > 0) {
                $store_city_and_city_loc .= ' ' . $address_cityLocation;
            }
            if (strlen($store_city_and_city_loc) > 0) {
                $store_city_and_city_loc = <<<HTML
<p class="gtst-store-address getstorify-wrap">
    <i class="fa fa-location-arrow"></i> $store_city_and_city_loc
</p>
HTML;
            }

            $viewOffers = '';
            if (isset($store['live_offer_count']) && $store['live_offer_count'] > 0) {
                $viewOffers = <<<HTML
<span class="gtst-store-view-offer"><a class="gtst-store-view-offer-link" href="{$storePageLink}">Store Offers</a></span>
HTML;
            }

            $footerHTML = '';
            if (strlen($viewOffers) || strlen($googleMap_Store)) {
                $footerHTML = <<<HTML
<div class="gtst-store-card-footer">
    {$googleMap_Store}
    {$viewOffers}
</div>
HTML;
            }

            $storeCardHTML = <<<HTML
<div class="gtst-store-card">
    <div class="gtst-store-card-header">
        {$storeCoverImage}
    </div>
    <div class="gtst-store-card-body">
        <p class="gtst-store-title"><a class="gtst-store-view-store-link" href="{$storePageLink}">{$storeName}</a></p>
        <p class="gtst-store-description">{$storeDescription}</p>
        {$store_city_and_city_loc}
        {$contactPhone}
    </div>
    {$footerHTML}
</div>
HTML;

            // set up the column width
            if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['columns']) &&
                in_array(intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['columns']), [1, 2, 3, 4])
            ) {
                $col_width = 12 / intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['columns']);
            } else {
                $col_width = 12;
            }

            $html .= <<<HTML
<div class='col-sm-12 col-md-6 col-lg-{$col_width}'>
{$storeCardHTML}
</div>
HTML;
        }

        return $html;
    }

    /**
     * This will return a single store card
     *
     * @param array $data
     * @return string
     */
    public static function getStore_MDB($data)
    {
        $html = "";

        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        $storePageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['store_page'] . '/' . $data['storeid'];

        $storeName = isset($data['storename']) ? trim($data['storename']) : '';

        $storeDescription = isset($data['storedescription']) ? trim($data['storedescription']) : '';

        $address = '';
        if (isset($data['address1'])) {
            $address .= trim($data['address1']);
        }
        if (isset($data['address2'])) {
            $address .= ' ' . trim($data['address2']);
        }

        $address_cityLocation = '';
        if (isset($data['city_location'])) {
            $address_cityLocation = trim($data['city_location']);
        }

        $address_city = '';
        if (isset($data['city'])) {
            $address_city = trim($data['city']);
        }

        $store_city_and_city_loc = '';
        if (strlen($address) > 0) {
            $store_city_and_city_loc .= $address;
        }
        if (strlen($address_city)) {
            $store_city_and_city_loc .= ' ' . $address_city;
        }
        if (strlen($address_cityLocation)) {
            $store_city_and_city_loc .= ' ' . $address_cityLocation;
        }
        if (strlen($store_city_and_city_loc)) {
            $store_city_and_city_loc = <<<HTML
<p class="gtst-store-address getstorify-wrap">
    <i class="fa fa-location-arrow"></i> $store_city_and_city_loc
</p>
HTML;
        }

        $contactPhone = '';
        if (isset($data['contactphone'])) {

            $contactPhoneNo = trim($data['contactphone']);
            if ($contactPhoneNo[0] !== '+') {
                $contactPhoneNo = '+' . $contactPhoneNo;
            }

            $contactPhone = <<<HTML
<p class="gtst-store-contact-phone"><i class="fa fa-phone"></i> {$contactPhoneNo}</p>
HTML;

        }

        $storeCoverImage = '';
        if (isset($data['storecover']) && isset($data['storecoverthumbnail'])) {
            $storeCoverImage = <<<HTML
<a class="gtst-store-view-store-link" href="{$storePageLink}"><img src="{$data['storecoverthumbnail']}" data-src="{$data['storecover']}" class="gtst-store-cover-img"></a>
HTML;
        }

        $googleMap_Store = '';
        if (isset($data['latitude']) && isset($data['longitude'])) {
            $mapLoc = "https://maps.google.com/?q=" . $data['latitude'] . ',' . $data['longitude'];
            $googleMap_Store = <<<HTML
<span class="gtst-store-icon map-marker"><a class="gtst-store-view-offer-store-location" href="{$mapLoc}"><i class="fa fa-map-marker"></i></a></span>
HTML;

        }

        $viewOffers = '';
        if (isset($data['live_offer_count']) && $data['live_offer_count'] > 0) {
            $viewOffers = <<<HTML
<span class="gtst-store-view-offer"><a class="gtst-store-view-offer-link" href="{$storePageLink}">Store Offers</a></span>
HTML;
        }

        $footerHTML = '';
        if (strlen($googleMap_Store)) {
            $footerHTML = <<<HTML
<div class="gtst-store-card-footer">
    {$googleMap_Store}
    {$viewOffers}
</div>
HTML;
        }

        $storeCardHTML = <<<HTML
<div class="gtst-store-card">
    <div class="gtst-store-card-header">
        {$storeCoverImage}
    </div>
    <div class="gtst-store-card-body">
        <p class="gtst-store-title"><a class="gtst-store-view-store-link" href="{$storePageLink}">{$storeName}</a></p>
        <p class="gtst-store-description">{$storeDescription}</p>
        {$store_city_and_city_loc}
        {$contactPhone}
    </div>
    {$footerHTML}
</div>
HTML;

        $html .= <<<HTML
{$storeCardHTML}
HTML;

        return $html;
    }

    /**
     * This method will return the prev next buttons.
     *
     * @param int $count This represents the number of stores fetched in the given page.
     * @param int $page
     * @param int $pagelimit
     * @return string
     */
    public static function getPrevNextButtons($count, $page, $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT)
    {
        $prevNextNavButtons = "";

        $homeLink = get_permalink();

        // add prev-next nav button
        if ($count == $pagelimit) {

            // if no. of stores fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of stores fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;

            }

        }

        return $prevNextNavButtons;
    }

    /**
     * This method will return the prev next buttons for the page listing the store search result.
     *
     * @param int $count This represents the number of stores fetched in the given page.
     * @param int $page
     * @param int $pagelimit
     * @param null|string $getparams
     * @return string
     */
    public static function getPrevNextButtons_search_store($count, $page, $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT, $getparams = null)
    {
        $prevNextNavButtons = "";

        $homeLink = get_permalink();

        // add prev-next nav button
        if ($count == $pagelimit) {

            // if no. of stores fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}/?gs-page={$nextPage}&{$getparams}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}/?gs-page={$prevPage}&{$getparams}'" class="getstorify btn float-left"> &larr; Prev </button>
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}/?gs-page={$nextPage}&{$getparams}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of stores fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button data-permalink="{$homeLink}" onclick="window.location='{$homeLink}/?gs-page={$prevPage}&{$getparams}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;
            }

        }

        return $prevNextNavButtons;
    }
}
