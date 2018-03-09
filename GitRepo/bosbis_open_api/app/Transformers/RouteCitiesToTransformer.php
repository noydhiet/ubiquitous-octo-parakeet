<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/22/17
 * Time: 11:03 AM
 */

namespace App\Transformers;


use App\Models\RouteCitiesTo;
use League\Fractal\TransformerAbstract;

class RouteCitiesToTransformer extends TransformerAbstract
{

    public function transform(RouteCitiesTo $message)
    {
        return [
            'routeCitiesTo'     => [
                'citiesFrom'    => [
                    'cityCode'  => $message->cityCode,
                    'citName'   => $message->cityName,
                    'provinceId'   => $message->provinceId,
                    'provinceName' => $message->provinceName
                ],
                'citiesTo'      => [
                    'cityCode'  => $message->cityCode,
                    'citName'   =>   $message->cityName,
                    'provinceId'   => $message->provinceId,
                    'provinceName' => $message->provinceName
                ],
            ],
        ];
    }

}