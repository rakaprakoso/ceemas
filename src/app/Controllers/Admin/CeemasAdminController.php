<?php

namespace Rakadprakoso\Ceemas\app\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\models\Config;
use Rakadprakoso\Ceemas\app\Traits\helper;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Cookie;


class CeemasAdminController extends CeemasGlobalDataController
{
    use helper;
    //use CeemasGlobalDataController;
    public function setting(Request $request){
        //return $this->ceemas_setting;

        $config_data = Config::get();
        foreach ($config_data as $key => $value) {
            $config[$value->key] = $value->value;
        }
        //return $config;
        return view('ceemas::admin.setting')
        ->with('config',$config);
    }
    public function settingSave(Request $request){

        $exception = array("_token", "time_format", "date_format", "time_format_txt", "date_format_txt");
        foreach ($request->request as $key => $value) {
            if (in_array($key, $exception)!=true) {
                Config::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }
        Config::updateOrCreate(
            ['key' => 'date_format'],
            ['value' => $request->date_format_txt]
        );
        Config::updateOrCreate(
            ['key' => 'time_format'],
            ['value' => $request->time_format_txt]
        );
        return redirect()->route('admin.setting');


    }

}
