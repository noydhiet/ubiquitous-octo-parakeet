<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/22/17
 * Time: 9:36 AM
 */

namespace App\Transformers;
use App\Models\RouteCitiesFrom;
use League\Fractal\TransformerAbstract;

class RouteCitiesFromTransformer extends TransformerAbstract
{

    public function transform(RouteCitiesFrom $message)
    {
        return [
            'cityCode'     => $message->cityCode,
            'cityName'     => $message->cityName,
            'provinceId'   => $message->provinceId,
            'provinceName' => $message->provinceName
        ];
    }

}