<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Cookie;

class CeemasPageController extends CeemasGlobalDataController
{
    //
    public function home(Request $request){
        return view('ceemas::admin.page.index');
    }

    public function login_page(){
        return "halo";
    }

    public function add($a, $b){
        $result = $a + $b;
	    return view('cemas::add', compact('result'));
    }

    public function subtract($a, $b){
    	echo $a - $b;
    }
}
