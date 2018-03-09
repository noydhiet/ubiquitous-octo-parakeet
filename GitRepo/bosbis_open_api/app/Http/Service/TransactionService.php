<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/12/18
 * Time: 9:58 PM
 */

namespace App\Http\Service;


use App\BbAgg_route;
use App\Common\Config;
use App\Ordered;
use App\Transaction;

class TransactionService
{

    public static function orderTransaction($data, $bosbisUser){

        $username = Config::$clientName;
        $password = Config::$clientKey;

        $service_url = Config::getBaseUrl() . '/bis-transaction/postReservation';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept-version: 4'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response, true);

        if($decoded['error'] == true){
            return $decoded;
        }
        self::saveOrdered($data, $decoded, $bosbisUser);

        $decoded = self::validateResponseOrder($decoded, $data);

        return $decoded;

        //var_dump($decoded);
        //return $decoded;

        
    }



    public static function orderConfirmTransaction($data, $bosbisUser){

        $username = Config::$clientName;
        $password = Config::$clientKey;

        $service_url = Config::getBaseUrl() . '/bis-transaction/confirmReservation';

        $totalPayment = $data['totalPayment'];

        $ordered = Ordered::where('t_payment_code', $data['paymentCode'])->first();

        $data['totalPayment'] = $ordered->t_real_payment;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$service_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept-version: 4'
        ));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_response=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $decoded = json_decode($curl_response, true);
        if($decoded['error'] == true){
            return $decoded;
        }

        $decoded = self::validateResponseConfirmation($decoded, $data, $ordered, $totalPayment);

        self::saveTransaction($decoded, $bosbisUser, $ordered, $totalPayment);
        
        return $decoded;

    }

    public static function saveOrdered($data, $decoded, $bosbisUser){

        $ordered = new Ordered();

        $bbAggRoute = BbAgg_route::where('route_id',$data['routeId'])->first();

        //var_dump('ROUTE : '.$data['routeId']);

        $ordered->t_order_datetime = $decoded['reservation']['reservationTime'];
        $ordered->t_payment_code = $decoded['reservation']['paymentCode'];
        $ordered->t_update_datetime = $decoded['reservation']['reservationTime'];
        $ordered->t_departure_date = $decoded['reservation']['route']['departureDate'];
        $ordered->route_id = $data['routeId'];
        $ordered->t_list_seats = $decoded['reservation']['listSeatNumber'];
        $ordered->t_total_passengers = $decoded['reservation']['totalPassengers'];
        $ordered->t_total_payment = $decoded['reservation']['totalPayment'] + ($bbAggRoute->online_markup * $decoded['reservation']['totalPassengers']) ;
        $ordered->t_real_payment = $decoded['reservation']['totalPayment'];
        $ordered->t_status = $decoded['reservation']['reservationStatus'];
        $ordered->t_sold_by = $bosbisUser->api_bosbis_user_id;
        $ordered->t_user_company = $bosbisUser->api_bosbis_user_company;
        if($bbAggRoute->online_commission_type == 2) {
            $ordered->t_online_commission = ($bbAggRoute->online_commission / 100) * $decoded['reservation']['totalPayment'];
        }else{
            $ordered->t_online_commission = $bbAggRoute->online_commission * $decoded['reservation']['totalPassengers'];
        }
        $ordered->t_expire_datetime = $decoded['reservation']['expireTime'];

        $ordered->save();

    }

    public static function saveTransaction($decoded, $bosbisUser){

        $bbAggRoute = BbAgg_route::where('route_id',$decoded['transaction']['route']['routeId'])->first();
        //$ordered = new Ordered();

        $ordered = Ordered::where('t_payment_code', $decoded['transaction']['paymentCode'])->first();
        $ordered->t_status = 3;

        foreach ($decoded['transaction']['passengers'] as $indexPsg => $valPsg){
            $transaction = new Transaction();

            $transaction->t_order_datetime = $decoded['transaction']['reservationTime'];
            $transaction->t_payment_code = $decoded['transaction']['paymentCode'];
            $transaction->t_update_datetime = $decoded['transaction']['reservationTime'];
            $transaction->t_paid_datetime = $decoded['transaction']['paidDateTime'];
            $transaction->t_user_company = $bosbisUser->api_bosbis_user_company;
            $transaction->t_online_commission = $bbAggRoute->online_commission;
            //$transaction->t_online_commission = 100000;
            $transaction->t_departure_date = $decoded['transaction']['route']['departureDate'];
            $transaction->route_id = $decoded['transaction']['route']['routeId'];
            $transaction->t_status = $decoded['transaction']['transactionStatus'];
            $transaction->t_sold_by = $bosbisUser->api_bosbis_user_id;

            $transaction->t_seat_number = $decoded['transaction']['passengers'][$indexPsg]['seatNumber'];
            $transaction->t_route_price = $decoded['transaction']['passengers'][$indexPsg]['price'];
            $transaction->t_booking_code = $decoded['transaction']['passengers'][$indexPsg]['bookingCode'];
            $transaction->save();
        }

        $ordered->save();

    }

    public static function validateResponseOrder($decoded, $data){

        $bbAggRoute = BbAgg_route::where('route_id',$data['routeId'])->first();

        $decoded['reservation']['totalPayment'] = $decoded['reservation']['totalPayment'] + ($bbAggRoute->online_markup * $decoded['reservation']['totalPassengers']) ;
        $decoded['reservation']['route']['routePrice'] = $decoded['reservation']['route']['routePrice'] + $bbAggRoute->online_markup;

        return $decoded;

    }

    public static function validateResponseConfirmation($decoded, $data, $ordered, $totalPayment){

        $decoded['transaction']['route']['routePrice'] = $totalPayment / $decoded['transaction']['totalPassengers'];
        $decoded['transaction']['totalPayment'] = $totalPayment;

        foreach ($decoded['transaction']['passengers'] as $indexPsg => $valPsg){
            $decoded['transaction']['passengers'][$indexPsg]['price'] = $totalPayment / $decoded['transaction']['totalPassengers'];
        }

        return $decoded;

    }

}