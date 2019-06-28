<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: wp-shortcode.php
 * Description: This page contains the WP shortcode of this plugin.
 */

/**
 * This function will return html based on the shortcode and its settings.
 *
 * @return string
 */
function getStorifyOffersPlugin_ShortCode_getResultHTML_func()
{
    /**
     * constants
     */
    require_once __DIR__ . '/config/constants.php';

    /**
     * Template
     */
    require_once __DIR__ . '/view/template/GetStorify_OfferTemplate.php';
    require_once __DIR__ . '/view/template/GetStorify_StoreTemplate.php';
    require_once __DIR__ . '/view/template/GetStorify_ItemTemplate.php';

    /**
     * Autoload getStorify Offers API Service SDK
     */
    require_once __DIR__ . '/GetStorifyOffers/autoload.php';

    /**
     * set this with necessary credentials.
     */
    $app_id = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_ID);
    $app_token = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_APP_TOKEN);
    $app_user_id = get_option(GETSTORIFY_OFFERS_PLUGIN_WP_OPTIONS_TABLE_OPTION_NAME_PLUGIN_USER_ID);

    define('GETSTORIFY_OFFERS_API_SERVICE_AUTH_APPID', $app_id);
    define('GETSTORIFY_OFFERS_API_SERVICE_AUTH_APPTOKEN', $app_token);
    define('GETSTORIFY_OFFERS_API_SERVICE_AUTH_USERID', $app_user_id);

    /**
     * create object
     */
    $GetStorifyOffersAPIServiceObj = new \GetStorifyOffers\GetStorifyOffers(
        GETSTORIFY_OFFERS_API_SERVICE_AUTH_APPID,
        GETSTORIFY_OFFERS_API_SERVICE_AUTH_USERID,
        GETSTORIFY_OFFERS_API_SERVICE_AUTH_APPTOKEN
    );

    /**
     * get access token
     */
    $result = $GetStorifyOffersAPIServiceObj->getAccessToken();

    /**
     * is access token issued
     */
    if (isset($result['success'])) {

        // get page
        $page = intval($_GET['gs-page']);
        if ($page < 1) {
            $page = 1;
        }

        /**
         * =================================================
         * get the shortcode params
         * =================================================
         */
        // get from the shortcode: columns
        if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['columns'])) {
            $shortcode_columns = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['columns']);
            $shortcode_columns = ($shortcode_columns < 1) ? 1 : $shortcode_columns;
        } else {
            $shortcode_columns = 1;
        }

        // get from the shortcode: view
        if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['view'])) {
            $shortcode_view = $GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['view'];
        } else {
            $shortcode_view = 'offers';
        }

        // set the shortcode user id to app userid
        $shortcode_userid = $app_user_id;

        // get from the shortcode: storeid
        if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['storeid'])) {
            $shortcode_storeid = $GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['storeid'];
        } else {
            $shortcode_storeid = null;
        }

        // get from the shortcode: offerid
        if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offerid'])) {
            $shortcode_offerid = $GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offerid'];
        } else {
            $shortcode_offerid = null;
        }

        // get from the shortcode: offer_itemid
        if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_itemid'])) {
            $shortcode_offer_itemid = $GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_itemid'];
        } else {
            $shortcode_offer_itemid = null;
        }

        /**
         * =================================================
         * fetch the data
         * =================================================
         */
        $html = '';
        $prevNextBtnHTML = '';
        switch ($shortcode_view) {

            /**
             * fetching data: offers
             */
            case 'offers':

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                // get from the shortcode
                if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_per_page'])) {
                    $pagelimit = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_per_page']);
                } else {
                    $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT;
                }

                $offerResult = $GetStorifyOffersAPIServiceObj->getOffer(
                    null,   // storeid
                    null,   // offerid
                    null,   // offertitle
                    'LIVE',   // offerstatus
                    null,   // store city
                    null,    // store city location
                    $page,
                    $pagelimit
                );

                if (isset($offerResult['success'])) {

                    $html = GetStorify_OfferTemplate::getOffers_MDB($offerResult['success']);

                    // get nav html
                    $prevNextBtnHTML = GetStorify_OfferTemplate::getPrevNextButtons(count($offerResult['success']), $page, $pagelimit);

                } else if (isset($offerResult['error']) && $offerResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html = "<div class='col-12'>No offers found!</div>";
                    } else {
                        $html = "<div class='col-12'>You have reached the end.</div>";
                    }

                    if ($page > 1) {
                        // get nav html
                        $prevNextBtnHTML = GetStorify_OfferTemplate::getPrevNextButtons(count($offerResult['success']), $page, $pagelimit);
                    }

                } else {

                    $html = "<div class='col-12'>Error: {$offerResult['message']}</div>";

                }

                break;


            /**
             * fetching data: offers popular
             */
            case 'offers_popular':

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT;

                $offerResult = $GetStorifyOffersAPIServiceObj->getLivePopularOffer(
                    null,   // storeid
                    null,   // offerid
                    null,   // offertitle
                    null,   // store city
                    null,    // store city location
                    $page,
                    $pagelimit
                );

                if (isset($offerResult['success'])) {

                    $html = GetStorify_OfferTemplate::getOffers_MDB($offerResult['success']);

                } else if (isset($offerResult['error']) && $offerResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html = "<div class='col-12'>No offers found!</div>";
                    } else {
                        $html = "<div class='col-12'>You have reached the end.</div>";
                    }

                } else {

                    $html = "<div class='col-12'>Error: {$offerResult['message']}</div>";

                }

                break;

            /**
             * fetching data: stores
             */
            case 'stores':

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                // get from the shortcode: store_per_page
                if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['store_per_page'])) {
                    $pagelimit = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['store_per_page']);
                } else {
                    $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT;
                }

                $storeResult = $GetStorifyOffersAPIServiceObj->getStore(
                    null,   // storeid
                    null,   // storename
                    null,   // city
                    null,   // city location
                    $page,
                    $pagelimit
                );

                if (isset($storeResult['success'])) {

                    $html = GetStorify_StoreTemplate::getStores_MDB($storeResult['success']);

                    // get nav html
                    $prevNextBtnHTML = GetStorify_StoreTemplate::getPrevNextButtons(count($storeResult['success']), $page, $pagelimit);

                } else if (isset($storeResult['error']) && $storeResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html = "<div class='col-12'>No stores found!</div>";
                    } else {
                        $html = "<div class='col-12'>You have reached the end.</div>";
                    }

                    if ($page > 1) {
                        // get nav html
                        $prevNextBtnHTML = GetStorify_StoreTemplate::getPrevNextButtons(count($storeResult['success']), $page, $pagelimit);
                    }

                } else {

                    $html = "<div class='col-12'>Error: {$storeResult['message']}</div>";

                }

                break;

            /**
             * fetching data: stores with offers
             */
            case 'stores_with_offers':

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                // get from the shortcode
                if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['store_per_page'])) {
                    $pagelimit = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['store_per_page']);
                } else {
                    $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT;
                }

                $storeResult = $GetStorifyOffersAPIServiceObj->getStore_With_Live_Offers(
                    null,   // storeid
                    null,   // storename
                    null,   // city
                    null,   // city location
                    $page,
                    $pagelimit
                );

                if (isset($storeResult['success'])) {

                    $html = GetStorify_StoreTemplate::getStores_MDB($storeResult['success']);

                    // get nav html
                    $prevNextBtnHTML = GetStorify_StoreTemplate::getPrevNextButtons(count($storeResult['success']), $page, $pagelimit);

                } else if (isset($storeResult['error']) && $storeResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html = "<div class='col-12'>No stores found!</div>";
                    } else {
                        $html = "<div class='col-12'>You have reached the end.</div>";
                    }

                    if ($page > 1) {
                        // get nav html
                        $prevNextBtnHTML = GetStorify_StoreTemplate::getPrevNextButtons(count($storeResult['success']), $page, $pagelimit);
                    }

                } else {

                    $html = "<div class='col-12'>Error: {$storeResult['message']}</div>";

                }
                break;

            /**
             * fetching data: offers of a store
             */
            case 'store_offers':

                $storeid = trim($_GET['gs-storeid']);

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                // fetching specific store
                $storeResult = $GetStorifyOffersAPIServiceObj->getStore(
                    $storeid,
                    null,   // storename
                    null,   // city
                    null,   // city location
                    1,      // page
                    1       // pagelimit
                );

                if (isset($storeResult['success'])) {

                    $prevNextOfferBtnHTML = '';

                    $html_store = GetStorify_StoreTemplate::getStore_MDB($storeResult['success'][0]);

                    // get from the shortcode
                    if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_per_page'])) {
                        $pagelimit = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['offer_per_page']);
                    } else {
                        $pagelimit = GETSTORIFY_OFFERS_PLUGIN_API_SERVICE_DB_PAGE_LIMIT;
                    }

                    /**
                     * fetch offers of the store
                     */
                    $offerResult = $GetStorifyOffersAPIServiceObj->getOffer(
                        $storeid,
                        null,   // offerid
                        null,   // offertitle
                        'LIVE', // offerstatus,
                        null,   // store city
                        null,   // store city location
                        $page,
                        $pagelimit
                    );

                    if (isset($offerResult['success'])) {

                        $html_offer = GetStorify_OfferTemplate::getStoreOffers_MDB($offerResult['success']);

                        // get nav html
                        $prevNextOfferBtnHTML = GetStorify_OfferTemplate::getPrevNextButtons_Store($storeid, count($offerResult['success']), $page, $pagelimit);

                    } else if (isset($offerResult['error']) && $offerResult['message'] === 'No match found') {

                        if ($page == 1) {
                            $html = "<div class='col-12'>No offers found!</div>";
                        } else {
                            $html = "<div class='col-12'>You have reached the end.</div>";
                        }

                        if ($page > 1) {
                            // get nav html
                            $prevNextOfferBtnHTML = GetStorify_OfferTemplate::getPrevNextButtons_Store($storeid, count($offerResult['success']), $page, $pagelimit);
                        }

                    } else {

                        $html_offer = "<div class='col-12'>Error: {$offerResult['message']}</div>";

                    }

                    $html_store = <<<HTML
<div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2">
{$html_store}
<div class="row">
{$html_offer}
</div>
<div class="row">
<div class="col-12">
{$prevNextOfferBtnHTML}
</div>
</div>
</div>
HTML;
                } else if (isset($storeResult['error']) && $storeResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html_store = "<div class='col-12'>No store found!</div>";
                    } else {
                        $html_store = "<div class='col-12'>You have reached the end.</div>";
                    }

                } else {

                    $html_store = "<div class='col-12'>Error: {$storeResult['message']}</div>";

                }

                $html = $html_store;

                break;

            /**
             * fetching data: items of an offer of a store
             */
            case 'store_offer_items':

                $page = intval($_GET['gs-page']);
                if ($page < 1) {
                    $page = 1;
                }

                $offerid = trim($_GET['gs-offerid']);

                $offerResult = $GetStorifyOffersAPIServiceObj->getOffer(
                    null,       // storeid
                    $offerid,
                    null,       // offertitle
                    null,       // offerstatus
                    null,       // store city
                    null,       // store city location
                    1,          // page
                    1           // pagelimit
                );

                $prevNextOfferItemBtnHTML = '';

                if (isset($offerResult['success'])) {

                    $html_offer = GetStorify_OfferTemplate::getOffer_MDB($offerResult['success'][0]);

                    $storeid = $offerResult['success'][0]['storeid'];

                    $userid = $offerResult['success'][0]['userid'];

                    // get from the shortcode
                    if (isset($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['item_per_page'])) {
                        $pagelimit = intval($GLOBALS[GETSTORIFY_OFFERS_PLUGIN_WP_SHORTCODE_PARAMS]['item_per_page']);
                    } else {
                        $pagelimit = 20;
                    }

                    /**
                     * fetching items of the offer
                     */
                    $itemResult = $GetStorifyOffersAPIServiceObj->getOfferItems(
                        $storeid,
                        $offerid,
                        null,       // offer item id
                        null,       // offer item name
                        null,       // item category
                        $page,
                        $pagelimit
                    );

                    if (isset($itemResult['success'])) {

                        $html_item = GetStorify_ItemTemplate::getItems_MDB($itemResult['success']);

                        // get nav html
                        $prevNextOfferItemBtnHTML = GetStorify_ItemTemplate::getPrevNextButtons_Offer($offerid, count($itemResult['success']), $page, $pagelimit);

                    } else if (isset($itemResult['error']) && $itemResult['message'] === 'No match found') {

                        if ($page == 1) {
                            $html_item = "<div class='col-12'>No item found!</div>";
                        } else {
                            $html_item = "<div class='col-12'>You have reached the end.</div>";
                        }

                        if ($page > 1) {
                            // get nav html
                            $prevNextOfferItemBtnHTML = GetStorify_ItemTemplate::getPrevNextButtons_Offer($offerid, count($itemResult['success']), $page, $pagelimit);
                        }

                    } else {

                        $html_item = "<div class='col-12'>Error: {$itemResult['message']}</div>";

                    }

                    $html_offer = <<<HTML
<div class="col-sm-12 col-md-12 col-lg-12">
{$html_offer}
<div class="row">
{$html_item}
</div>
<div class="row">
<div class="col-12">
{$prevNextOfferItemBtnHTML}
</div>
</div>
</div>
HTML;

                } else if (isset($offerResult['error']) && $offerResult['message'] === 'No match found') {

                    if ($page == 1) {
                        $html_offer = "<div class='col-12'>No offer found!</div>";
                    } else {
                        $html_offer = "<div class='col-12'>You have reached the end.</div>";
                    }

                } else {

                    $html_offer = "<div class='col-12'>Error: {$offerResult['message']}</div>";

                }

                $html = $html_offer;

                break;

            default:
                $html = "Invalid value set for 'view' attribute in the shortcode.";

        }

        $shortCodeResultHTML = <<<HTML
<div class="getstorify-twbs">
<div class="container-fluid">
<div class="row">
{$html}
</div>
<div class="row">
<div class="col-12">
{$prevNextBtnHTML}
</div>
</div>
</div>
</div>
HTML;

    } else {
        $shortCodeResultHTML = "<h1>Failed to authenticate your getStorify Offer plugin credentials.</h1>";
    }

    /**
     * include other UI files
     */
    require_once __DIR__ . '/view/common/style_css.php';
    require_once __DIR__ . '/view/common/footer.php';

    return $shortCodeResultHTML;

}
