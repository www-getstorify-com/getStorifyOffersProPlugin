<?php
/**
 * Author: Yusuf Shakeel
 * Date: 14-jun-2019 fri
 * Version: 1.2
 *
 * File: GetStorify.php
 * Description: This is the main file.
 */

namespace GetStorifyOffers;

require_once __DIR__ . '/Config/Constants.php';

use GetStorifyOffers\Authentication\AccessToken;
use GetStorifyOffers\User\User;
use GetStorifyOffers\User\Stores;
use GetStorifyOffers\User\Offers;
use GetStorifyOffers\User\OfferItems;

/**
 * Class GetStorifyOffers
 * @package GetStorifyOffers
 */
class GetStorifyOffers
{
    /**
     * The AppID of the user app.
     *
     * @var string
     */
    private $appid = '';

    /**
     * The UserId of the user.
     *
     * @var string
     */
    private $userid = '';

    /**
     * The AppToken (this is the secret) for the user app.
     *
     * @var string
     */
    private $apptoken = '';

    /**
     * The Access Token.
     *
     * @var string
     */
    private $accesstoken = '';

    /**
     * The domain from where the request is being sent.
     *
     * @var string
     */
    private $origin = '';

    /**
     * AccessToken constructor.
     *
     * @param string $appid
     * @param string $userid
     * @param string $apptoken
     */
    public function __construct($appid, $userid, $apptoken)
    {
        $this->appid = $appid;
        $this->userid = $userid;
        $this->apptoken = $apptoken;
    }

    /**
     * This will validate the user AppID and fetch access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        $obj = new AccessToken();
        $result = $obj->getAccessToken(
            $this->appid,
            $this->userid,
            $this->apptoken
        );

        if (isset($result['success'])) {
            $this->accesstoken = $result['success']['accesstoken'];
            $this->origin = $result['success']['domain'];
        }

        return $result;
    }

    /**
     * This method will return the user detail.
     *
     * @return mixed
     */
    public function getUserDetail()
    {
        $obj = new User();
        $result = $obj->getUserDetail(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin]
        );

        return $result;
    }

    /**
     * This method will fetch all the ACTIVE stores of the user.
     *
     * @param null|string $storeid
     * @param null|string $storename
     * @param null|string $city
     * @param null|string $citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getStore($storeid = null, $storename = null, $city = null, $citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $obj = new Stores();
        $result = $obj->getStore(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin],
            $storeid,
            $storename,
            $city,
            $citylocation,
            $page,
            $pagelimit
        );

        return $result;
    }

    /**
     * This method will fetch all the ACTIVE stores of the user with LIVE offers.
     *
     * @param null $storeid
     * @param null $storename
     * @param null $city
     * @param null $citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getStore_With_Live_Offers($storeid = null, $storename = null, $city = null, $citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $obj = new Stores();
        $result = $obj->getStore_With_Live_Offers(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin],
            $storeid,
            $storename,
            $city,
            $citylocation,
            $page,
            $pagelimit
        );

        return $result;
    }

    /**
     * This method will fetch all the offers of ACTIVE stores of a user.
     *
     * @param null $storeid
     * @param null $offerid
     * @param null $offertitle
     * @param null $offerstatus
     * @param null $store_city
     * @param null $store_citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getOffer($storeid = null, $offerid = null, $offertitle = null, $offerstatus = null, $store_city = null, $store_citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $obj = new Offers();
        $result = $obj->getOffer(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin],
            $storeid,
            $offerid,
            $offertitle,
            $offerstatus,
            $store_city,
            $store_citylocation,
            $page,
            $pagelimit
        );

        return $result;
    }

    /**
     * This method will fetch all the LIVE popular offers of ACTIVE stores of a user.
     *
     * @param null $storeid
     * @param null $offerid
     * @param null $offertitle
     * @param null $store_city
     * @param null $store_citylocation
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getLivePopularOffer($storeid = null, $offerid = null, $offertitle = null, $store_city = null, $store_citylocation = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $obj = new Offers();
        $result = $obj->getLivePopularOffer(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin],
            $storeid,
            $offerid,
            $offertitle,
            $store_city,
            $store_citylocation,
            $page,
            $pagelimit
        );

        return $result;
    }

    /**
     * This method will fetch all the offers of ACTIVE stores of a user.
     *
     * @param $storeid
     * @param $offerid
     * @param null $offer_itemid
     * @param null $offer_item_name
     * @param null $item_categoryid
     * @param int $page
     * @param int $pagelimit
     * @return array
     */
    public function getOfferItems($storeid, $offerid, $offer_itemid = null, $offer_item_name = null, $item_categoryid = null, $page = 1, $pagelimit = GETSTORIFY_OFFERS_API_SERVICE_DB_PAGE_LIMIT)
    {
        $obj = new OfferItems();
        $result = $obj->getOfferItems(
            $this->appid,
            $this->userid,
            $this->accesstoken,
            ['origin' => $this->origin],
            $storeid,
            $offerid,
            $offer_itemid,
            $offer_item_name,
            $item_categoryid,
            $page,
            $pagelimit
        );

        return $result;
    }

}