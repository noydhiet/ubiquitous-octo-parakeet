<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/3/18
 * Time: 8:47 PM
 */

namespace App\Http\Service;


use App\BbAgg_route;
use App\BbAggSchedule;
use Faker\Provider\DateTime;
use App\Common\Config;

class ScheduleService
{


    public static function serviceGetSchedule($cityFrom, $cityTo, $dateTrip, $OperatorUser, $fromRow, $limitRow){

        /*$service_url = 'https://engine.bosbis.com/bis-schedule/schedules?
                    from='.$cityFrom.
                    '&to='.$cityTo.
                    '&date='.$dateTrip.
                    'onlineSaleStatus=1&poId='.$OperatorUser;
        $username = 'API-SJGvqjJ3e';
        $password = '$2a$08$FKXQ5Lmnh3yG6R65K3Sdz.oWNO8/r4RUsm8fSktG.6.GwTD6./mRC';

        var_dump($service_url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response);
        var_dump('STATUS CODE : '.$status_code);

        var_dump('REAL JSON : '.$decoded);
        var_dump('END REAL JSON');

        /*foreach($decoded['schedules'] AS $item){
            foreach ($item['routes'] AS $itemRoutes){
                unset($decoded['schedules']['routes']['subPo']['subPoEmail']);
                unset($decoded['subPo']['subPoPhone']);
            }
        }*/
        //self::validateSchedule();

        //$decodedFinal = json_decode($decoded);
        //return self::validateSchedule($decoded, $dateTrip);

        $username = Config::$clientName;
        $password = Config::$clientKey;

        if($fromRow == -1 || $limitRow == -1){
            $service_url = Config::getBaseUrl() . '/bis-schedule/schedules?from='.$cityFrom.'&to='.$cityTo.'&date='.$dateTrip.'&onlineSaleStatus=1&poId='.$OperatorUser;
        }else{
            $service_url = Config::getBaseUrl() . '/bis-schedule/schedules?from='.$cityFrom.'&to='.$cityTo.'&date='.$dateTrip.'&onlineSaleStatus=1&poId='.$OperatorUser.'&fromRow='.$fromRow.'&limitRow='.$limitRow;
        }


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

        $decoded = json_decode($curl_response, true);
        //return $decoded;
        return self::validateSchedule($decoded, $dateTrip);

    }

    public static function serviceGetScheduleByRoute($routeId, $dateTrip, $OperatorUser){

        $username = Config::$clientName;
        $password = Config::$clientKey;

            $service_url = Config::getBaseUrl() . '/bis-schedule/schedules?routeId='.$routeId.'&date='.$dateTrip.'&onlineSaleStatus=1&poId='.$OperatorUser;

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

        $decoded = json_decode($curl_response, true);
        //return $decoded;
        return self::validateSchedule($decoded, $dateTrip);

    }

    public static function validateSchedule($decoded, $dateTrip){



        //$json2 = json_decode($json2,true);
        $json2 = $decoded;
        $validTrip = 0;
        $varNumFound = $json2['numFound'];
        $indexNumFound = 0;
        $varEndIndex = $json2['endIndex'];
        $indexEndIndex = 0;

        foreach ($json2['schedules'] as $indexSchd => $valSchd){
            $indexCalc = 0;
            $indexTotal = 0;
            $tripId = $json2['schedules'][$indexSchd]['trip']['tripId'];
            $validTrip = 0;
            $indexCalcRoute = 0;
            foreach ($json2['schedules'][$indexSchd]['routes'] as $indexRoutes => $valRoutes){
                $indexCalcRoute = count($json2['schedules'][$indexSchd]['routes']);
                $indexTotal = count($json2['schedules'][$indexSchd]['routes']) + $indexCalc;
                $varRouteId = $json2['schedules'][$indexSchd]['routes'][$indexRoutes]['routeId'];
                $varSubPoId = $json2['schedules'][$indexSchd]['routes'][$indexRoutes]['subPo']['subPoId'];
                $varRoutePrice = $json2['schedules'][$indexSchd]['routes'][$indexRoutes]['routePrice'];

                //check available tripId and d
                $objTripPo = BbAggSchedule::where('trip_id', $tripId)
                                          ->where('subpo_id', $varSubPoId)
                                          ->first();

                $tripDate = date_create($dateTrip);
                $currDate = date_create(date('Y-m-d'));
                $diff = date_diff($tripDate, $currDate);
                if($objTripPo <> null && $diff->format('%a') >= $objTripPo->sales_type){
                    $json2['schedules'][$indexSchd]['routes'][$indexRoutes]['subPoSeats'] = $objTripPo->subpo_seats;
                }

                if($objTripPo <> null && $diff->format('%a') < $objTripPo->sales_type){
                    $validTrip = 1;
                }

                $bbAgg_route = BbAgg_route::where('route_id',$varRouteId)->first();
                if($bbAgg_route <> null ){
                    if($objTripPo->subpo_seats == null || $objTripPo->subpo_seats == ""){
                        unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]);
                        $indexCalc = $indexCalc + 1;
                    }
                    else {
                        if ($bbAgg_route->online_sales != 1) {
                            unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]);
                            $indexCalc = $indexCalc + 1;

                        } else {
                            $json2['schedules'][$indexSchd]['routes'][$indexRoutes]['routePrice'] = $varRoutePrice + $bbAgg_route->online_markup;
                            unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]['routeSales']);
                            unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]['subPo']['subPoAddress']);
                            unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]['subPo']['subPoEmail']);
                            unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]['subPo']['subPoPhone']);
                        }
                    }
                }else{
                    unset($json2['schedules'][$indexSchd]['routes'][$indexRoutes]);
                    $indexCalc = $indexCalc + 1;
                }
            }
            //var_dump('validtrip : '.$validTrip);
            if($indexTotal == $indexCalc || $validTrip == 1){
                unset($json2['schedules'][$indexSchd]['trip']);
                unset($json2['schedules'][$indexSchd]['fleet']);
                unset($json2['schedules'][$indexSchd]['po']);
                unset($json2['schedules'][$indexSchd]['template']);
                unset($json2['schedules'][$indexSchd]['routes']);
                unset($json2['schedules'][$indexSchd]);
                $indexNumFound++;
                $indexEndIndex++;
            }

            unset($json2['schedules'][$indexSchd]['trip']['tripAvailableSeats']);
            unset($json2['schedules'][$indexSchd]['trip']['tripGate']);
            unset($json2['schedules'][$indexSchd]['trip']['tripSoldSeats']);
            unset($json2['schedules'][$indexSchd]['trip']['tripStatus']);
            unset($json2['schedules'][$indexSchd]['trip']['tripIsActive']);
            unset($json2['schedules'][$indexSchd]['po']['poLogo']);
            unset($json2['schedules'][$indexSchd]['po']['poType']);


        }

        $json2['numFound'] = $varNumFound - $indexNumFound;
        $json2['endIndex'] = $varEndIndex - $indexEndIndex;
        $json2['schedules'] = array_values($json2['schedules']);
        return $json2;

    }

}