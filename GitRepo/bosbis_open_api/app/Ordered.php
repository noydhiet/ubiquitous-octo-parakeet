<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/18/18
 * Time: 10:26 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Ordered extends Model
{

    protected $table = 'ordered';

    protected $fillable = [
        't_id',
        't_order_datetime',
        't_payment_code',
        't_expire_datetime',
        't_update_datetime',
        't_departure_date',
        'route_id',
        't_list_seats',
        't_total_passengers',
        't_total_payment',
        't_status',
        't_sold_by',
        't_user_company',
        't_online_commission',
        't_real_payment'];

}