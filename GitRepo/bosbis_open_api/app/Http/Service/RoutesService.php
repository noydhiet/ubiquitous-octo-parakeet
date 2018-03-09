<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/24/17
 * Time: 2:37 PM
 */

namespace App\Http\Service;


use App\Common\Config;

class RoutesService
{

    private  $username;
    private  $password;

    function __construct($persons_name) {
        $this->username = 'API-SJGvqjJ3e';
        $this->password = '$2a$08$FKXQ5Lmnh3yG6R65K3Sdz.oWNO8/r4RUsm8fSktG.6.GwTD6./mRC';
    }

    public static function serviceGetAllSample(){

        $service_url = 'https://engine.bosbis.com/bis-trip/routeCitiesFrom?poId=58,360';
        $username = 'API-SJGvqjJ3e';
        $password = '$2a$08$FKXQ5Lmnh3yG6R65K3Sdz.oWNO8/r4RUsm8fSktG.6.GwTD6./mRC';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        /*$curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additional info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        //echo 'response ok!';
        //var_export($decoded->response);
*/
        $decoded = json_decode($curl_response);
        return $decoded;

    }

    public static function serviceRoutesCitiesFrom($operatorId){

        $service_url = Config::getBaseUrl() . '/bis-trip/routeCitiesFrom?poId='.$operatorId;
        $username = Config::$clientName;
        $password = Config::$clientKey;
        //$username = 'API-SJGvqjJ3e';
        //$password = '$2a$08$FKXQ5Lmnh3yG6R65K3Sdz.oWNO8/r4RUsm8fSktG.6.GwTD6./mRC';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response);
        return $decoded;

    }

    public static function serviceRoutesCitiesTo($poId, $cityCode){

        $service_url = Config::getBaseUrl() .'/bis-trip/routeCitiesTo?poId='.$poId.'&cityCodeFrom='.$cityCode;
        $username = Config::$clientName;
        $password = Config::$clientKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response);
        return $decoded;

    }

    public static function serviceRouteOperator($poId, $cityCodeFrom, $cityCodeTo){

        $service_url = Config::getBaseUrl() .'/bis-trip/routeOperators?poId='.$poId.'&cityCodeFrom='.$cityCodeFrom . '&cityCodeTo=' .$cityCodeTo;
        
        $username = Config::$clientName;
        $password = Config::$clientKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response);
        return $decoded;

    }

}