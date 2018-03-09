<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/28/17
 * Time: 11:20 PM
 */

namespace App\Common;


use App\ApiBosbisUser;

class Auth
{

    public static function isAuthorize($clientIdAuth, $clientKeyAuth, $clientId){

        $BosbisUser = ApiBosbisUser::where('api_bosbis_user_id',$clientId)->first();

        if ($clientIdAuth = $BosbisUser->api_bosbis_user_client_id && $clientKeyAuth = $BosbisUser->api_bosbis_user_client_key){
            return false;
        }
        return true;

    }

}