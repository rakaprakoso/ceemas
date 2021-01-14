<?php

namespace Rakadprakoso\Ceemas\app\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Cookie;

class CeemasController extends CeemasGlobalDataController
{
    //
    public function home(Request $request){
        return view('ceemas::admin.page.index');
        if ($request->get('status')) {
            return view('ceemas::admin.page.index');
        } else{
            return view('ceemas::admin.authentication.login');
        }

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
