<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 3/1/18
 * Time: 1:37 PM
 */

namespace App\Common;


class Config
{

    /**
     * Your merchant's server key
     * @static
     */
    public static $serverKey;
    /**
     * Your merchant's client key
     * @static
     */
    public static $clientKey = '$2a$08$Y4CpcWkqIJ3NEJx3ANuhC.7wTTzn29nX6z9a2YhjjN2PXLvfivbwK';
    /**
     * Your merchant's client name
     * @static
     */
    public static $clientName = 'API-BktXuo_w-';
    /**
     * true for production
     * false for sandbox mode
     * @static
     */
    public static $isProduction = false;
    /**
     * Set it true to enable 3D Secure by default
     * @static
     */
    public static $is3ds = false;
    /**
     * Enable request params sanitizer (validate and modify charge request params).
     * See Bosbis_Sanitizer for more details
     * @static
     */
    public static $isSanitized = false;
    /**
     * Default options for every request
     * @static
     */
    public static $PHP_AUTH_USER = 'API-kPi6Ib1900T4MOa';
    /**
     * Default options for every request
     * @static
     */
    public static $PHP_AUTH_PW = '$2y$10$FY3ELUEvOOpLnEy0X9BhqObq27HAwAwtJwgHKgJGe8yYe2dcbtxTm';
    /**
     * Default options for every request
     * @static
     */
    public static $curlOptions = array();

    const SANDBOX_BASE_URL = 'https://sandbox.bisnetwork.id/apicore';
    const PRODUCTION_BASE_URL = 'https://apicore.bisnetwork.id';

    /**
     * @return string Bosbis API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        return Config::$isProduction ?
            Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }

    /**
     * @return string Snap API URL, depends on $isProduction
     */

}