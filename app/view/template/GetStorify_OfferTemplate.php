<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: GetStorify_OfferTemplate.php
 * Description: This file contains offer templates.
 */

require_once __DIR__ . '/../../config/constants.php';

class GetStorify_OfferTemplate
{
    /**
     * This will return cards of all the offers.
     *
     * @param array $data
     * @return string
     */
    public static function getOffers_MDB($data)
    {
        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        $html = "";

        foreach ($data as $offer) {

            $offerPageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['offer_page'] . '/' . $offer['offerid'];

            $storename = isset($offer['storename']) ? trim($offer['storename']) : '';

            $offerTitle = isset($offer['offertitle']) ? trim($offer['offertitle']) : '';

            $offerDescription = isset($offer['offerdescription']) ? trim($offer['offerdescription']) : '';
            if (strlen($offerDescription) > 100) {
                $offerDescription = substr($offerDescription, 0, 99) + '...';
            }

            $offerCoverImage = '';
            if (isset($offer['offercover']) && isset($offer['offercoverthumbnail'])) {
                $offerCoverImage = <<<HTML
<a class="gtst-offer-view-offer-link" href="{$offerPageLink}"><img src="{$offer['offercoverthumbnail']}" data-src="{$offer['offercover']}" class="gtst-offer-cover-img"></a>
HTML;
            }

            $googleMap_OfferStore = '';
            if (isset($offer['store_latitude']) && isset($offer['store_longitude'])) {
                $mapLoc = "https://maps.google.com/?q=" . $offer['store_latitude'] . ',' . $offer['store_longitude'];
                $googleMap_OfferStore = <<<HTML
<span class="gtst-offer-icon map-marker"><a class="gtst-offer-view-offer-store-location" href="{$mapLoc}"><i class="fa fa-map-marker"></i></a></span>
HTML;

            }

            $offerTillHTML = "";
            if ($offer['offerstatus'] === 'LIVE') {
                $endsIn = round((strtotime($offer['offerendat']) - strtotime(date('Y-m-d H:i:s', time()))) / 86400); // 86400 sec = 1 day

                if ($endsIn == 0 || $endsIn == 1) {
                    $offerEndDate = 'Ends soon!';
                } else {
                    $offerEndDate = 'Ends in ' . $endsIn . (($endsIn == 1) ? ' day' : ' days');
                }

                $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> {$offerEndDate}</p>
HTML;
            } else if ($offer['offerstatus'] === 'EXPIRED') {

                $dateFormat = (new DateTime($offer['offerendat']))->format('d-M-Y');

                $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> Offer expired on {$dateFormat}</p>
HTML;
            }

            $offerShortlink = '';
            if (isset($offer['shortlink'])) {
                $offerShortlink = <<<HTML
<span class="gtst-offer-icon share"><a class="gtst-offer-view-offer-sharelink clipboardjs" data-clipboard-text="{$offerPageLink}" href="#" data-shortlink="{$offerPageLink}"><i class="fa fa-share-alt"></i></a></span>
HTML;
            }


            $store_cityLocation = '';
            if (isset($offer['store_city_location'])) {
                $store_cityLocation = trim($offer['store_city_location']);
            }

            $store_city = '';
            if (isset($offer['store_city'])) {
                $store_city = trim($offer['store_city']);
            }

            $store_city_and_city_loc = '';
            if (strlen($store_city) > 0) {
                $store_city_and_city_loc .= $store_city;
            }
            if (strlen($store_cityLocation) > 0) {
                $store_city_and_city_loc .= ' ' . $store_cityLocation;
            }
            if (strlen($store_city_and_city_loc) > 0) {
                $store_city_and_city_loc = <<<HTML
<p class="gtst-store-address getstorify-wrap">
    <i class="fa fa-location-arrow"></i> $store_city_and_city_loc
</p>
HTML;
            }

            $offerCardHTML = <<<HTML
<div class="gtst-offer-card">
    <div class="gtst-offer-card-header">
        {$offerCoverImage}
    </div>
    <div class="gtst-offer-card-body">
        <p class="gtst-offer-title"><a class="gtst-offer-view-offer-link" href="{$offerPageLink}">{$offerTitle}</a></p>
        <p class="gtst-offer-description">{$offerDescription}</p>
        <p class="gtst-offer-storename">Offer By: {$storename}</p>
        {$store_city_and_city_loc}
        {$offerTillHTML}
    </div>
    <div class="gtst-offer-card-footer">
        {$googleMap_OfferStore}
        {$offerShortlink}
        <span class="gtst-offer-view-offer"><a class="gtst-offer-view-offer-link" href="{$offerPageLink}">View Offer</a></span>
    </div>
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
{$offerCardHTML}
</div>
HTML;
        }

        return $html;
    }

    /**
     * This will return cards of all the offers of a store.
     *
     * @param array $data
     * @return string
     */
    public static function getStoreOffers_MDB($data)
    {
        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        $html = "";

        foreach ($data as $offer) {

            $offerPageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['offer_page'] . '/' . $offer['offerid'];

            $storename = isset($offer['storename']) ? trim($offer['storename']) : '';

            $offerTitle = isset($offer['offertitle']) ? trim($offer['offertitle']) : '';

            $offerDescription = isset($offer['offerdescription']) ? trim($offer['offerdescription']) : '';
            if (strlen($offerDescription) > 100) {
                $offerDescription = substr($offerDescription, 0, 99) + '...';
            }

            $offerCoverImage = '';
            if (isset($offer['offercover']) && isset($offer['offercoverthumbnail'])) {
                $offerCoverImage = <<<HTML
<a class="gtst-offer-view-offer-link" href="{$offerPageLink}"><img src="{$offer['offercoverthumbnail']}" data-src="{$offer['offercover']}" class="gtst-offer-cover-img"></a>
HTML;
            }

            $googleMap_OfferStore = '';
            if (isset($offer['store_latitude']) && isset($offer['store_longitude'])) {
                $mapLoc = "https://maps.google.com/?q=" . $offer['store_latitude'] . ',' . $offer['store_longitude'];
                $googleMap_OfferStore = <<<HTML
<span class="gtst-offer-icon map-marker"><a class="gtst-offer-view-offer-store-location" href="{$mapLoc}"><i class="fa fa-map-marker"></i></a></span>
HTML;

            }

            $offerTillHTML = "";
            if ($offer['offerstatus'] === 'LIVE') {
                $endsIn = round((strtotime($offer['offerendat']) - strtotime(date('Y-m-d H:i:s', time()))) / 86400); // 86400 sec = 1 day

                if ($endsIn == 0 || $endsIn == 1) {
                    $offerEndDate = 'Ends soon!';
                } else {
                    $offerEndDate = 'Ends in ' . $endsIn . (($endsIn == 1) ? ' day' : ' days');
                }

                $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> {$offerEndDate}</p>
HTML;
            } else if ($offer['offerstatus'] === 'EXPIRED') {
                $dateFormat = (new DateTime($offer['offerendat']))->format('d-M-Y');

                $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> Offer expired on {$dateFormat}</p>
HTML;
            }

            $offerShortlink = '';
            if (isset($offer['shortlink'])) {
                $offerShortlink = <<<HTML
<span class="gtst-offer-icon share"><a class="gtst-offer-view-offer-sharelink clipboardjs" data-clipboard-text="{$offerPageLink}" href="#" data-shortlink="{$offerPageLink}"><i class="fa fa-share-alt"></i></a></span>
HTML;
            }

            $store_cityLocation = '';
            if (isset($offer['store_city_location'])) {
                $store_cityLocation = trim($offer['store_city_location']);
            }

            $store_city = '';
            if (isset($offer['store_city'])) {
                $store_city = trim($offer['store_city']);
            }

            $store_city_and_city_loc = '';
            if (strlen($store_city) > 0) {
                $store_city_and_city_loc .= $store_city;
            }
            if (strlen($store_cityLocation) > 0) {
                $store_city_and_city_loc .= ' ' . $store_cityLocation;
            }
            if (strlen($store_city_and_city_loc) > 0) {
                $store_city_and_city_loc = <<<HTML
<p class="gtst-store-address getstorify-wrap">
    <i class="fa fa-location-arrow"></i> $store_city_and_city_loc
</p>
HTML;
            }

            $offerCardHTML = <<<HTML
<div class="gtst-offer-card">
    <div class="gtst-offer-card-header">
        {$offerCoverImage}
    </div>
    <div class="gtst-offer-card-body">
        <p class="gtst-offer-title"><a class="gtst-offer-view-offer-link" href="{$offerPageLink}">{$offerTitle}</a></p>
        <p class="gtst-offer-description">{$offerDescription}</p>
        <p class="gtst-offer-storename">Offer By: {$storename}</p>
        {$store_city_and_city_loc}
        {$offerTillHTML}
    </div>
    <div class="gtst-offer-card-footer">
        {$googleMap_OfferStore}
        {$offerShortlink}
        <span class="gtst-offer-view-offer"><a class="gtst-offer-view-offer-link" href="{$offerPageLink}">View Offer</a></span>
    </div>
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
<div class='col-sm-12 col-md-6 col-lg-6'>
{$offerCardHTML}
</div>
HTML;
        }

        return $html;
    }

    /**
     * This will return single offer card.
     *
     * @param array $data
     * @return string
     */
    public static function getOffer_MDB($data)
    {
        $gs_wp_plugin_options_pages = json_decode(
            get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_PAGES),
            true
        );

        $html = "";

        $offerPageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['offer_page'] . '/' . $data['offerid'];

        $storename = isset($data['storename']) ? trim($data['storename']) : '';

        $offerTitle = isset($data['offertitle']) ? trim($data['offertitle']) : '';

        $offerDescription = isset($data['offerdescription']) ? trim($data['offerdescription']) : '';

        $offerCoverImage = '';
        if (isset($data['offercover']) && isset($data['offercoverthumbnail'])) {
            $offerCoverImage = <<<HTML
<a class="gtst-offer-view-offer-link" href="{$offerPageLink}"><img src="{$data['offercoverthumbnail']}" data-src="{$data['offercover']}" class="gtst-offer-cover-img"></a>
HTML;
        }

        $offerTillHTML = "";
        if ($data['offerstatus'] === 'LIVE') {
            $endsIn = round((strtotime($data['offerendat']) - strtotime(date('Y-m-d H:i:s', time()))) / 86400); // 86400 sec = 1 day

            if ($endsIn == 0 || $endsIn == 1) {
                $offerEndDate = 'Ends soon!';
            } else {
                $offerEndDate = 'Ends in ' . $endsIn . (($endsIn == 1) ? ' day' : ' days');
            }

            $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> {$offerEndDate}</p>
HTML;
        } else if ($data['offerstatus'] === 'EXPIRED') {
            $dateFormat = (new DateTime($data['offerendat']))->format('d-M-Y');

            $offerTillHTML = <<<HTML
<p class="gtst-offer-ends-in"><i class="fa fa-clock-o"></i> Offer expired on {$dateFormat}</p>
HTML;
        }

        // offer start at and offer end at dates
        $offer_StartEndData = '';
        if (isset($data['offerstartat'])) {

            $date = date('d-M-Y, h:i:s A', strtotime($data['offerstartat']));

            $offer_StartEndData .= <<<HTML
<span style="margin-right: 15px;"><span class="label label-default">From:</span> {$date}</span>
HTML;

        }
        if (isset($data['offerendat'])) {

            $date = date('d-M-Y, h:i:s A', strtotime($data['offerendat']));

            $offer_StartEndData .= <<<HTML
<span style="margin-right: 15px;"><span class="label label-default">To:</span> {$date}</span>
HTML;

        }

        $offerShortlink = '';
        if (isset($data['shortlink'])) {
            $offerShortlink = <<<HTML
<span class="gtst-offer-icon share"><a class="gtst-offer-view-offer-sharelink clipboardjs" data-clipboard-text="{$offerPageLink}" href="#" data-shortlink="{$offerPageLink}"><i class="fa fa-share-alt"></i></a></span>
HTML;
        }


        $store_cityLocation = '';
        if (isset($data['store_city_location'])) {
            $store_cityLocation = trim($data['store_city_location']);
        }

        $store_city = '';
        if (isset($data['store_city'])) {
            $store_city = trim($data['store_city']);
        }

        $store_city_and_city_loc = '';
        if (strlen($store_city) > 0) {
            $store_city_and_city_loc .= $store_city;
        }
        if (strlen($store_cityLocation) > 0) {
            $store_city_and_city_loc .= ' ' . $store_cityLocation;
        }
        if (strlen($store_city_and_city_loc) > 0) {
            $store_city_and_city_loc = <<<HTML
<p class="gtst-store-address getstorify-wrap">
    <i class="fa fa-location-arrow"></i> $store_city_and_city_loc
</p>
HTML;
        }

        $googleMap_OfferStore = '';
        if (isset($data['store_latitude']) && isset($data['store_longitude'])) {
            $mapLoc = "https://maps.google.com/?q=" . $data['store_latitude'] . ',' . $data['store_longitude'];
            $googleMap_OfferStore = <<<HTML
<span class="gtst-offer-icon map-marker"><a class="gtst-offer-view-offer-store-location" href="{$mapLoc}"><i class="fa fa-map-marker"></i></a></span>
HTML;

        }


        $storePageLink = get_home_url() . '/' . $gs_wp_plugin_options_pages['store_page'] . '/' . $data['storeid'];

        $viewStore = <<<HTML
<span class="gtst-offer-view-offer"><a class="gtst-offer-view-offer-link" href="{$storePageLink}">View Store</a></span>
HTML;

        $offerCardHTML = <<<HTML
<div class="gtst-offer-card">
    <div class="gtst-offer-card-header">
        {$offerCoverImage}
    </div>
    <div class="gtst-offer-card-body">
        <p class="gtst-offer-title"><a class="gtst-offer-view-offer-link" href="{$offerPageLink}">{$offerTitle}</a></p>
        <p class="gtst-offer-description">{$offerDescription}</p>
        <p class="gtst-offer-storename">Offer By: {$storename}</p>
        {$store_city_and_city_loc}
        <div style="display: none;">{$offerTillHTML}</div>
        <div style="margin-top: 10px; margin-bottom: 10px;">{$offer_StartEndData}</div>
    </div>
    <div class="gtst-offer-card-footer">
        {$googleMap_OfferStore}
        {$offerShortlink}
        {$viewStore}
    </div>
</div>
HTML;

        $html .= <<<HTML
{$offerCardHTML}
HTML;

        return $html;
    }

    /**
     * This method will return the prev next buttons.
     *
     * @param int $count This represents the number of offer fetched in the given page.
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

            // if no. of offers fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML

<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
<button onclick="window.location='{$homeLink}page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of offers fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;

            }

        }

        return $prevNextNavButtons;
    }

    /**
     * This method will return the prev next buttons for the offers of a store.
     *
     * @param string $storeid
     * @param int $count This represents the number of offer fetched in the given page.
     * @param int $page
     * @param int $pagelimit
     * @return string
     */
    public static function getPrevNextButtons_Store($storeid, $count, $page, $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT)
    {
        $prevNextNavButtons = "";

        $homeLink = get_permalink();

        // add prev-next nav button
        if ($count == $pagelimit) {

            // if no. of offers fetched equals the page limit

            // on page 1 just return next button
            if ($page === 1) {
                $nextPage = $page + 1;

                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$storeid}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;

            } else {

                // on page > 1 return both prev next buttons

                $prevPage = $page - 1;
                $nextPage = $page + 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$storeid}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
<button onclick="window.location='{$homeLink}{$storeid}/page/{$nextPage}'" class="getstorify btn float-right"> Next &rarr; </button>
</div>
HTML;
            }

        } else {

            // no. of offers fetched is less than the page limit

            if ($page > 1) {

                // on page > 1 return prev button

                $prevPage = $page - 1;
                $prevNextNavButtons = <<<HTML
<div style="margin-top: 15px; margin-bottom: 15px; clear: both; min-height: 50px;">
<button onclick="window.location='{$homeLink}{$storeid}/page/{$prevPage}'" class="getstorify btn float-left"> &larr; Prev </button>
</div>
HTML;

            }

        }

        return $prevNextNavButtons;
    }
}
