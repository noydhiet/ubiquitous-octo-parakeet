<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/3/18
 * Time: 8:46 PM
 */

namespace App\Http\Controllers;

use App\ApiBosbisUserOperator;
use App\Http\Service;
use GuzzleHttp\Client;
use App\Common;
use Illuminate\Http;
use App\ApiBosbisUser;
use App\Common\Config;

class ScheduleController extends Controller
{

    public function getScheduleController($cityFrom, $cityTo, $dateTrip, $fromRow, $limitRow){

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

            $curl_response = Service\ScheduleService::serviceGetSchedule($cityFrom, $cityTo, $dateTrip, $bosbisUser->api_bosbis_user_operator_id, $fromRow, $limitRow);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);
    }

    public function getScheduleControllerPlain($cityFrom, $cityTo, $dateTrip){

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

            $curl_response = Service\ScheduleService::serviceGetSchedule($cityFrom, $cityTo, $dateTrip, $bosbisUser->api_bosbis_user_operator_id, -1, -1);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);
    }

    public function getScheduleControllerByRoute($routeId, $dateTrip){

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

            $curl_response = Service\ScheduleService::serviceGetScheduleByRoute($routeId, $dateTrip, $bosbisUser->api_bosbis_user_operator_id);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);
    }

}