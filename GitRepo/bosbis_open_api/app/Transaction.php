<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/18/18
 * Time: 10:26 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'transaction';

    protected $fillable = [
        't_order_datetime',
        't_paid_datetime',
        't_payment_code',
        't_booking_code',
        't_expire_datetime',
        't_update_datetime',
        't_departure_date',
        'route_id',
        't_seat_number',
        't_route_price',
        't_status',
        't_sold_by',
        't_user_company',
        't_online_commission'];

}