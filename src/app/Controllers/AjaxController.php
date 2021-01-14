<?php

namespace Rakadprakoso\Ceemas\app\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Cookie;

class AjaxController extends Controller
{
    //
    public function dateFormat(Request $request){
        $format = $request->format;
        $date =date_create();
        $date = date_format($date,$format);
        return Response::json($date);

    }

}
