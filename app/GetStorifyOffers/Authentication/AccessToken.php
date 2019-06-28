<?php
/**
 * Author: Yusuf Shakeel
 * Date: 14-jun-2019 fri
 * Version: 1.0
 *
 * File: AccessToken.php
 * Description: This file contains AccessToken code.
 */

namespace GetStorifyOffers\Authentication;

/**
 * Class AccessToken
 * @package GetStorifyOffers\Authentication
 */
class AccessToken
{
    /**
     * This method will return the access token on success.
     *
     * @param string $appid
     * @param string $userid
     * @param string $apptoken
     * @return mixed
     */
    public function getAccessToken($appid, $userid, $apptoken)
    {
        $fields = array(
            'appid' => $appid,
            'userid' => $userid,
            'apptoken' => $apptoken
        );

        $ch = curl_init(GETSTORIFY_OFFERS_API_SERVICE_USER_AUTH_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
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