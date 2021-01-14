<?php

namespace Rakadprakoso\Ceemas\app\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\models\Config;
use Illuminate\Support\Facades\View;
use Rakadprakoso\Ceemas\app\Traits\helper;
use Cookie;

class CeemasGlobalDataController extends Controller
{
    protected $ceemas_setting;

    public function __construct()
    {
        // Fetch the Site Settings object
        $this->ceemas_setting = Config::all()->pluck(
            'value',
            'key'
          );
        View::share('ceemas_setting', $this->ceemas_setting);
    }
}
