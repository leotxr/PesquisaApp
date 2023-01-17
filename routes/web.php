<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
#Rota principal da pesquisa
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'App\Http\Controllers\RatingController@checkKey');


#Selects entre formularios da pesquisa para busca de dados no XClinic
Route::any('get-dados', 'App\Http\Controllers\RatingController@getDados')->name('get-dados');
Route::any('show-agenda', 'App\Http\Controllers\RatingController@getAgenda')->name('show-agenda');
Route::any('sendDados', 'App\Http\Controllers\RatingController@storeAgendamento')->name('sendDados');
Route::any('sendDadosAgenda', 'App\Http\Controllers\RatingController@storeAgenda')->name('sendDadosAgenda');
Route::any('sendDadosRecepcao', 'App\Http\Controllers\RatingController@storeRecepcao')->name('sendDadosRecepcao');
Route::any('sendDadosMed', 'App\Http\Controllers\FaturaController@store')->name('sendDadosMed');
Route::any('sendDadosUltri', 'App\Http\Controllers\RatingController@storeUltri')->name('sendDadosUltri');
Route::any('sendComent', 'App\Http\Controllers\RatingController@storeComent')->name('sendComent');


Route::any('ratingsHoje', 'App\Http\Controllers\RatingController@todayRatings')->name('ratingsHoje');
Route::any('ratingsMes', 'App\Http\Controllers\RatingController@monthRatings')->name('ratingsMes');
Route::any('ratingsAno', 'App\Http\Controllers\RatingController@yearRatings')->name('ratingsAno');
Route::any('countRatings', 'App\Http\Controllers\RatingController@countRatings')->name('countRatings');


#Relatorios
Route::get('busca-data', function () {
    return view('admin.rel-geral');
})->name('busca-data');

Route::get('rel-setores', function () {
    return view('admin.rel-setores');
})->name('rel-setores');

Route::get('rel-coment', function () {
    return view('admin.rel-coment');
})->name('rel-coment');

Route::any('resultByDate', 'App\Http\Controllers\RatingController@relatorioGeral')->name('resultByDate');
Route::any('showdatepicker', 'App\Http\Controllers\RatingController@showdatepicker')->name('showdatepicker');
Route::any('resultSetores', 'App\Http\Controllers\FaturaController@relatorioSetores')->name('resultSetores');
Route::any('resultComent', 'App\Http\Controllers\RatingController@relatorioComentario')->name('resultComent');

#Dashboard pós login
Route::get('/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
