<?php

Route::get('cemas', 'rakadprakoso\cemas\CemasController@home');
/*Route::get('cemas', function(){
	echo 'Hello from the calculator package!';
});*/
Route::get('tambah/{a}/{b}', 'rakadprakoso\cemas\CemasController@add');
Route::get('kurang/{a}/{b}', 'rakadprakoso\cemas\CemasController@subtract');