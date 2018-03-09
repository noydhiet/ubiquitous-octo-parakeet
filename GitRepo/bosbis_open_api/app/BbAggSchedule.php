<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 1/8/18
 * Time: 2:24 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class BbAggSchedule extends Model
{

    protected $table = 'bbagg_schedule';

    protected $fillable = [
        'bbagg_schedule_id',
        'trip_id',
        'subpo_id',
        'subpo_seats',
        'sales_type'];

}