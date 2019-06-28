<?php
/**
 * Author: Yusuf Shakeel
 * Date: 17-jun-2019 mon
 * Version: 1.0
 *
 * File: Offers.php
 * Description: This file contains offers code.
 */

namespace GetStorifyOffers\User;

/**
 * Class Offers
 * @package GetStorifyOffers\User
 */
class Offers
{
    /**
     * This method will fetch all the offers of ACTIVE stores of a user.
     *
     * @param string $appid
     * @param string $userid
     * @param string $accesstoken
     * @param array $header
     * @param null|string $storeid
     * @param null|string $offerid
     * @param null|string $offertitle
     * @param null|string $offerstatus
     * @param null|string $store_city
     * @param null|string $store_citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getOffer($appid, $userid, $accesstoken, $header, $storeid = null, $offerid = null, $offertitle = null, $offerstatus = null, $store_city = null, $store_citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $getParam = "?appid=$appid&userid=$userid&accesstoken=$accesstoken";
        $getParam .= "&page=$page";
        $getParam .= "&pagelimit=$pagelimit";

        if (isset($storeid)) {
            $getParam .= "&storeid=$storeid";
        }

        if (isset($offerid)) {
            $getParam .= "&offerid=$offerid";
        }

        if (isset($offertitle)) {
            $getParam .= "&offertitle=$offertitle";
        }

        if (isset($offerstatus)) {
            $getParam .= "&offerstatus=$offerstatus";
        }

        if (isset($store_city)) {
            $getParam .= "&store_city=$store_city";
        }

        if (isset($store_citylocation)) {
            $getParam .= "&store_city_location=$store_citylocation";
        }

        $url = GETSTORIFY_OFFERS_API_SERVICE_OFFERS_URL . $getParam;

        $headerArr = array(
            'Origin' => $header['origin']
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * This method will fetch all the LIVE popular offers of ACTIVE stores of a user.
     *
     * @param string $appid
     * @param string $userid
     * @param string $accesstoken
     * @param array $header
     * @param null|string $storeid
     * @param null|string $offerid
     * @param null|string $offertitle
     * @param null|string $store_city
     * @param null|string $store_citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getLivePopularOffer($appid, $userid, $accesstoken, $header, $storeid = null, $offerid = null, $offertitle = null, $store_city = null, $store_citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $getParam = "?appid=$appid&userid=$userid&accesstoken=$accesstoken";
        $getParam .= "&page=$page";
        $getParam .= "&pagelimit=$pagelimit";

        if (isset($storeid)) {
            $getParam .= "&storeid=$storeid";
        }

        if (isset($offerid)) {
            $getParam .= "&offerid=$offerid";
        }

        if (isset($offertitle)) {
            $getParam .= "&offertitle=$offertitle";
        }

        if (isset($offerstatus)) {
            $getParam .= "&offerstatus=$offerstatus";
        }

        if (isset($store_city)) {
            $getParam .= "&store_city=$store_city";
        }

        if (isset($store_citylocation)) {
            $getParam .= "&store_city_location=$store_citylocation";
        }

        $url = GETSTORIFY_OFFERS_API_SERVICE_OFFERS_LIVE_POPULAR_OFFERS_URL . $getParam;

        $headerArr = array(
            'Origin' => $header['origin']
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return json_decode($result, true);
    }
}