<?php
/**
 * Author: Yusuf Shakeel
 * Date: 14-jun-2019 fri
 * Version: 1.0
 *
 * File: Stores.php
 * Description: This file contains stores code.
 */

namespace GetStorifyOffers\User;

/**
 * Class Stores
 * @package GetStorifyOffers\User
 */
class Stores
{
    /**
     * This method will fetch all the ACTIVE stores of the user.
     *
     * @param string $appid
     * @param string $userid
     * @param string $accesstoken
     * @param array $header
     * @param null|string $storeid
     * @param null|string $storename
     * @param null|string $city
     * @param null|string $citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getStore($appid, $userid, $accesstoken, $header, $storeid = null, $storename = null, $city = null, $citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $getParam = "?appid=$appid&userid=$userid&accesstoken=$accesstoken";
        $getParam .= "&page=$page";
        $getParam .= "&pagelimit=$pagelimit";

        if (isset($storeid)) {
            $getParam .= "&storeid=$storeid";
        }

        if (isset($storename)) {
            $getParam .= "&storename=$storename";
        }

        if (isset($city)) {
            $getParam .= "&city=$city";
        }

        if (isset($citylocation)) {
            $getParam .= "&citylocation=$citylocation";
        }

        $url = GETSTORIFY_OFFERS_API_SERVICE_STORES_URL . $getParam;

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
     * This method will fetch all the ACTIVE stores of the user with LIVE offers.
     *
     * @param string $appid
     * @param string $userid
     * @param string $accesstoken
     * @param array $header
     * @param null|string $storeid
     * @param null|string $storename
     * @param null|string $city
     * @param null|string $citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getStore_With_Live_Offers($appid, $userid, $accesstoken, $header, $storeid = null, $storename = null, $city = null, $citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $getParam = "?appid=$appid&userid=$userid&accesstoken=$accesstoken";
        $getParam .= "&page=$page";
        $getParam .= "&pagelimit=$pagelimit";

        if (isset($storeid)) {
            $getParam .= "&storeid=$storeid";
        }

        if (isset($storename)) {
            $getParam .= "&storename=$storename";
        }

        if (isset($city)) {
            $getParam .= "&city=$city";
        }

        if (isset($citylocation)) {
            $getParam .= "&citylocation=$citylocation";
        }

        $url = GETSTORIFY_OFFERS_API_SERVICE_STORES_WITH_LIVE_OFFERS_URL . $getParam;

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