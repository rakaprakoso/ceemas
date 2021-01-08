<?php

Route::get('cemas', 'rakadprakoso\cemas\CemasController@home');
/*Route::get('cemas', function(){
	echo 'Hello from the calculator package!';
});*/
Route::group(['prefix'=>'cemas','as'=>'admin.'], function(){

	/*Route::group(['prefix'=>'file','as'=>'file.'], function(){
		Route::get('/', [
			'as' => 'index', 'uses' => 'rakadprakoso\cemas\CemasController@home'
		]);
    });
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });*/
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

	Route::resource('post', 'rakadprakoso\cemas\controllers\admin\PostController');
    Route::get('filemanager',  [
		'as' => 'filemanager', 'uses' => 'rakadprakoso\cemas\controllers\admin\FileManagerController@index'
	]);


	Route::get('tambah/{a}/{b}', [
		'as' => 'tambah', 'uses' => 'rakadprakoso\cemas\CemasController@add'
	]);

});

Route::get('tambah/{a}/{b}', 'rakadprakoso\cemas\CemasController@add');
Route::get('kurang/{a}/{b}', 'rakadprakoso\cemas\CemasController@subtract');
