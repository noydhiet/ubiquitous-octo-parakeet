<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/7/18
 * Time: 11:19 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class BbAgg_route extends Model
{

    protected $table = 'bbagg_route';

    protected $fillable = [
        'bbagg_route_id',
        'route_id',
        'online_commission',
        'online_markup',
        'online_sales',
        'online_commission_type']; //1:nominal 2:persen

}