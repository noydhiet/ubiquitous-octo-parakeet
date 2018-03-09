<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/22/17
 * Time: 11:32 AM
 */

namespace App\Transformers;


use App\Models\Operator;
use League\Fractal\TransformerAbstract;

class OperatorTransformer extends TransformerAbstract
{

    public function transform(Operator $message)
    {
        return [
            'operators' => [
                'poId'      => $message->poId,
                'poBrand'   => $message-> poBrand
            ]
        ];
    }

}