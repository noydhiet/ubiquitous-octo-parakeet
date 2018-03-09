<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/24/17
 * Time: 2:33 PM
 */

namespace App\Http\Controllers;

use App\ApiBosbisUser;
use App\ApiBosbisUserOperator;
use App\Http\Service;
use GuzzleHttp\Client;
use App\Common;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http;
use App\Common\Config;

class RoutesController extends Controller
{

    public function index(){

        $curl_response = Service\RoutesService::serviceGetAllSample();

        return response()->json($curl_response);

    }

    public function getBosbisUser($id){

        $BosbisUser  = ApiBosbisUser::find($id);

        return response()->json($BosbisUser);
    }

    public function getCitiesFrom(){

        //$request = new Http\Request();
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

        if($bosbisUser <> null){
            //$OperatorUser = ApiBosbisUserOperator::where('id_user', $clientId)->first();//get specific operator id based on client id

            $curl_response = Service\RoutesService::serviceRoutesCitiesFrom($bosbisUser->api_bosbis_user_operator_id);

            return response()->json($curl_response);
        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    public function getCitiesTo($cityCode){

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
            $curl_response = Service\RoutesService::serviceRoutesCitiesTo($bosbisUser->api_bosbis_user_operator_id, $cityCode);

            return response()->json($curl_response);
        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    public function getRoutesOperators($cityCodeFrom, $cityCodeTo){

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
            $curl_response = Service\RoutesService::serviceRouteOperator($bosbisUser->api_bosbis_user_operator_id, $cityCodeFrom, $cityCodeTo);

            return response()->json($curl_response);
        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

}