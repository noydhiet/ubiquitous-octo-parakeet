<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/22/17
 * Time: 11:02 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RouteCitiesTo extends Model
{

    protected $fillable = [
        'cityCode',
        'cityName',
        'provinceId',
        'provinceName',
    ];

}