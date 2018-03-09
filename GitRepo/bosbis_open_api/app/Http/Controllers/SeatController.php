<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 2/19/18
 * Time: 7:27 PM
 */

namespace App\Http\Controllers;

use App\Http\Service;
use GuzzleHttp\Client;
use App\Common;
use Illuminate\Http;
use App\ApiBosbisUser;
use App\Common\Config;


class SeatController extends Controller
{

    public function getSeatSold($tripId, $tripDate, $cityFrom, $cityTo){

        if(Config::$isProduction){
            $authUser = $_SERVER['PHP_AUTH_USER'];
            $authPw = $_SERVER['PHP_AUTH_PW'];
        }else{
            $authUser = Config::$PHP_AUTH_USER;
            $authPw = Config::$PHP_AUTH_PW;
        }

        $bosbisUser = ApiBosbisUser::where('api_bosbis_user_client_id',$authUser)
            ->where('api_bosbis_user_client_key',$authPw)
            ->first();

        if($bosbisUser <> null) {

            $curl_response = Service\SeatService::getSeatSoldService($tripId, $tripDate, $cityFrom, $cityTo);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    public function getSeatBooked($tripId, $tripDate, $cityFrom, $cityTo){

        if(Config::$isProduction){
            $authUser = $_SERVER['PHP_AUTH_USER'];
            $authPw = $_SERVER['PHP_AUTH_PW'];
        }else{
            $authUser = Config::$PHP_AUTH_USER;
            $authPw = Config::$PHP_AUTH_PW;
        }

        $bosbisUser = ApiBosbisUser::where('api_bosbis_user_client_id',$authUser)
            ->where('api_bosbis_user_client_key',$authPw)
            ->first();

        if($bosbisUser <> null) {

            $curl_response = Service\SeatService::getSeatBookedService($tripId, $tripDate, $cityFrom, $cityTo);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

}