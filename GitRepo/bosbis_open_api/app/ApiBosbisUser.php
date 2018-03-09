<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/21/17
 * Time: 9:15 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class ApiBosbisUser extends Model
{

    protected $table = 'api_bosbis_user';

    protected $fillable = [
    'api_bosbis_user_id',
    'api_bosbis_user_group',
    'api_bosbis_user_email',
    'api_bosbis_user_company',
    'api_bosbis_user_channel',
    'api_bosbis_user_client_id',
    'api_bosbis_user_client_key',
    'api_bosbis_user_scope',
    'api_bosbis_user_agent',
    'api_bosbis_user_active',
    'api_bosbis_user_regdate',
    'api_bosbis_user_operator_id'];

}