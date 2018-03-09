<?php
/**
 * Created by PhpStorm.
 * User: adhitiaherawan
 * Date: 12/21/17
 * Time: 9:20 PM
 */

namespace App\Http\Controllers;

use App\ApiBosbisUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BosbisUserController extends Controller
{

    public function index(){

        $BosbisUser  = ApiBosbisUser::all();

        return response()->json($BosbisUser);

    }

    public function getBosbisUser($id){

        $BosbisUser  = ApiBosbisUser::find($id);

        return response()->json($BosbisUser);
    }

}