<?php

Route::get('cemas', 'RakaDPrakoso\Cemas\CemasController@home');
/*Route::get('cemas', function(){
	echo 'Hello from the calculator package!';
});*/
Route::get('tambah/{a}/{b}', 'RakaDPrakoso\Cemas\CemasController@add');
Route::get('kurang/{a}/{b}', 'RakaDPrakoso\Cemas\CemasController@subtract');