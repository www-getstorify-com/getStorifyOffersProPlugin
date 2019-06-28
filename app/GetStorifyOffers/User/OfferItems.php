<?php
/**
 * Author: Yusuf Shakeel
 * Date: 17-jun-2019 mon
 * Version: 1.0
 *
 * File: OfferItems.php
 * Description: This file contains offer items code.
 */

namespace GetStorifyOffers\User;

/**
 * Class OfferItems
 * @package GetStorifyOffers\User
 */
class OfferItems
{
    /**
     * This method will fetch all the ACTIVE offer items of an ACTIVE store of a user.
     *
     * @param string $appid
     * @param string $userid
     * @param string $accesstoken
     * @param array $header
     * @param string $storeid
     * @param string $offerid
     * @param null|string $offer_itemid
     * @param null|string $offer_item_name
     * @param null $item_categoryid
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getOfferItems($appid, $userid, $accesstoken, $header, $storeid, $offerid, $offer_itemid = null, $offer_item_name = null, $item_categoryid = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
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

        if (isset($offer_itemid)) {
            $getParam .= "&offer_itemid=$offer_itemid";
        }

        if (isset($offer_item_name)) {
            $getParam .= "&offer_item_name=$offer_item_name";
        }

        if (isset($item_categoryid)) {
            $getParam .= "&item_categoryid=$item_categoryid";
        }

        $url = GETSTORIFY_OFFERS_API_SERVICE_OFFERS_ITEMS_URL . $getParam;

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