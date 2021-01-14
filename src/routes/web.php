<?php

use Rakadprakoso\Ceemas\Services\ConfigService\ConfigRepository;

$config = resolve(ConfigRepository::class);
// App middleware list
$middleware = $config->getMiddleware();
//$middleware[] = 'ceemas_auth';

Route::group([
    'as' => 'ajax.',
    'prefix'=>'ajax',
    'namespace'  => 'Rakadprakoso\Ceemas\app\Controllers',
], function () {
    Route::post('/dateFormat', 'AjaxController@dateFormat')->name('dateFormat');
});

Route::group([
    'middleware' => $middleware,
    'prefix'     => $config->getRoutePrefix(),
    'namespace'  => 'Rakadprakoso\Ceemas\app\Controllers',
    'as'         => 'admin.',
], function () {
    Route::get('/', 'CeemasController@home')->name('dashboard')->middleware('ceemas_dashboard');
    Route::post('/', 'AuthenticationController@login')->name('login');

    Route::group(['middleware' => 'ceemas_auth'], function () {
        Route::group([
            'as' => 'ajax',
            'prefix'=>'ajax',
        ], function () {
            Route::post('selectdisk', 'Admin\FileManagerController@ajaxSelectDisk')->name('SelectDisk');
        });

        Route::delete('/', 'AuthenticationController@logout')->name('logout');
        Route::get('/setting', 'Admin\CeemasAdminController@setting')->name('setting');
        Route::post('/setting', 'Admin\CeemasAdminController@settingSave')->name('settingSave');
        Route::get('filemanager',  [
            'as' => 'filemanager', 'uses' => 'Admin\FileManagerController@index'
        ]);
        //Route::get('/dashboard', 'CeemasController@home')->name('dashboard');

        Route::resource('post', 'Admin\PostController');
        Route::resource('category', 'Admin\PostCategoryController');
        Route::resource('tag', 'Admin\PostCategoryController');

      });


});

/*
Route::get('cemas', 'rakadprakoso\cemas\app\Controllers\CeemasController@home');
/*Route::get('cemas', function(){
	echo 'Hello from the calculator package!';
});*-/
Route::group(['prefix'=>'cemas','as'=>'admin.'], function(){

	/*Route::group(['prefix'=>'file','as'=>'file.'], function(){
		Route::get('/', [
			'as' => 'index', 'uses' => 'rakadprakoso\cemas\CemasController@home'
		]);
    });
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });*-/
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

	Route::resource('post', 'rakadprakoso\cemas\app\Controllers\admin\PostController');
    Route::get('filemanager',  [
		'as' => 'filemanager', 'uses' => 'rakadprakoso\cemas\app\Controllers\Admin\FileManagerController@index'
	]);


	Route::get('tambah/{a}/{b}', [
		'as' => 'tambah', 'uses' => 'rakadprakoso\cemas\app\controllers\CemasController@add'
	]);

});

Route::get('tambah/{a}/{b}', 'rakadprakoso\cemas\app\controllers\CemasController@add');
Route::get('kurang/{a}/{b}', 'rakadprakoso\cemas\app\controllers\CemasController@subtract');
*/
