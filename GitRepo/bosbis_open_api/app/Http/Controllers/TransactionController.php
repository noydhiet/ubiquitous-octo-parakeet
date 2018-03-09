<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/12/18
 * Time: 9:10 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Service;
use App\ApiBosbisUser;
use App\BbAggSchedule;
use App\Common\Config;


class TransactionController extends Controller
{

    public function postOrderController(Request $request){



        $data = $request->json()->all();
        //is
        //var_dump($data['routeId']);

        $today = time()+10800;
        $currTime = date("Y-m-d H:i", $today);

        $data['refferenceNumber'] = '';
        $data['paymentType'] = '';
        $data['expireTime'] = $currTime;

        //$data = \GuzzleHttp\json_encode($data,true);

        /*foreach ($data['passengers'] as $indexPsg => $valPsg){
            $name = $data['passengers'][$indexPsg]['name'];
            var_dump($name);
        }*/
        //var_dump($data);

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

            if(!self::validateJmlPassenger($data)){
                return response()->json(['error' => true, 'message' =>'Maksimal 4 Penumpang']);
            }

            if(!self::validateSeat($data)){
                return response()->json(['error' => true, 'message' =>'Salah Satu Atau Semua Kursi Tidak Untuk Dijual']);
            }

            $curl_response = Service\TransactionService::orderTransaction($data, $bosbisUser);

            return response()->json($curl_response);

        }


        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    //buat test ini
    public function postConfirmController(Request $request){



        $data = $request->json()->all();

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

            $curl_response = Service\TransactionService::confirmTransactionDua($data, $bosbisUser);

            return response()->json($curl_response);

        }


        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    public function postOrderConfirmController(Request $request){

        $data = $request->json()->all();
        //is
        //var_dump($data['routeId']);

        //$data = \GuzzleHttp\json_encode($data,true);

        /*foreach ($data['passengers'] as $indexPsg => $valPsg){
            $name = $data['passengers'][$indexPsg]['name'];
            var_dump($name);
        }*/
        //var_dump($data);

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


            $curl_response = Service\TransactionService::orderConfirmTransaction($data, $bosbisUser);

            return response()->json($curl_response);

        }

        return response()->json(['code' => 401, 'error' => true, 'message' =>'Anda Tidak Memiliki Akses']);

    }

    public static function validateJmlPassenger($decoded){

        $jmlPnp = 0;
        foreach($decoded['passengers'] as $indexPnp => $valPnp){
            $jmlPnp++;
        }

        if($jmlPnp > 4){
            return false;
        }
        else return true;

    }

    public static function validateSeat($decoded){

        $bbAggSchedule = BbAggSchedule::where('trip_id',$decoded['tripId'])->first();

        $arr_seat = explode(',',$bbAggSchedule->subpo_seats);

        foreach($decoded['passengers'] as $indexPnp => $valPnp){
            if(!in_array($decoded['passengers'][$indexPnp]['seatNumber'], $arr_seat)){
                return false;
            }
        }

        return true;

    }
}