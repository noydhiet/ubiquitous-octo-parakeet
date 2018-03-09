<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/28/17
 * Time: 11:01 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ApiBosbisUserOperator extends Model
{

    protected $table = 'bbagg_operator_user';

    protected $fillable = [
        'id_operator',
        'description'];

}