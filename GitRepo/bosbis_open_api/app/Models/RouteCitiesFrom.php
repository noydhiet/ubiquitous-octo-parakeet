<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/22/17
 * Time: 9:34 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RouteCitiesFrom extends Model
{

    protected $fillable = [
        'cityCode',
        'cityName',
        'provinceId',
        'provinceName',
    ];

}