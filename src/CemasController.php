<?php

namespace rakadprakoso\cemas;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CemasController extends Controller
{
    //
    public function home(){
        
	    return view('cemas::index');
    }

    public function add($a, $b){
        $result = $a + $b;
	    return view('cemas::add', compact('result'));
    }

    public function subtract($a, $b){
    	echo $a - $b;
    }
}
