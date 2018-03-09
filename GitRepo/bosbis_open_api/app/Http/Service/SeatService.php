<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 2/19/18
 * Time: 7:30 PM
 */

namespace App\Http\Service;


use App\Common\Config;

class SeatService
{

    public static function getSeatSoldService($tripId, $tripDate, $cityFrom, $cityTo){

        $service_url = Config::getBaseUrl() . '/bis-boarding/seatSold?tripId='.$tripId.'&date='.$tripDate.'&from='.$cityFrom.'&to='.$cityTo;
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

    public static function getSeatBookedService($tripId, $tripDate, $cityFrom, $cityTo){

        $service_url = Config::getBaseUrl() . '/bis-transaction/bookedSeat?tripId='.$tripId.'&date='.$tripDate.'&from='.$cityFrom.'&to='.$cityTo;
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