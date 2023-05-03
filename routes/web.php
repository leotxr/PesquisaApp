<?php

use App\Http\Controllers\GetDadosCliente;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDadosClienteController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StoreDadosController;

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

#Rota principal da pesquisa
Route::get('/', function () {
    return view('inicio');
});

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('teste', function () {
    return view('teste');
});



Route::get('comentarios/exportar/', [RatingController::class, 'export'])->name('export.comments');

#Selects entre formularios da pesquisa para busca de dados no XClinic
Route::post('GetDadosCliente', GetDadosClienteController::class)->name('GetDadosCliente');
Route::get('/AvaliarEmpresa/{id}', function () {
    return view('rate-ultri');
});
Route::get('/fim', function () {
    return view('fim');
});
#Route::post('StoreDados', RatingController::class, 'store')->name('StoreDados');


/*
Route::any('ratingsHoje', 'App\Http\Controllers\RatingController@todayRatings')->name('ratingsHoje');
Route::any('ratingsMes', 'App\Http\Controllers\RatingController@monthRatings')->name('ratingsMes');
Route::any('ratingsAno', 'App\Http\Controllers\RatingController@yearRatings')->name('ratingsAno');
Route::any('countRatings', 'App\Http\Controllers\RatingController@countRatings')->name('countRatings');
*/

#Relatorios
Route::get('rel-geral', function () {
    return view('admin.rel-geral');
})->name('rel-geral');

Route::get('rel-setores', function () {
    return view('admin.rel-setores');
})->name('rel-setores');

Route::get('comentarios', function () {
    return view('admin.rel-coment');
})->name('rel-coment');

Route::any('editComent', 'App\Http\Controllers\RatingController@editComment')->name('editComment');

Route::any('resultByDate', 'App\Http\Controllers\RatingController@relatorioGeral')->name('resultByDate');
Route::any('report', 'App\Http\Controllers\RatingController@report')->name('report');
Route::any('showdatepicker', 'App\Http\Controllers\RatingController@showdatepicker')->name('showdatepicker');
Route::any('resultSetores', 'App\Http\Controllers\FaturaController@relatorioSetores')->name('resultSetores');
Route::any('resultComent', 'App\Http\Controllers\RatingController@relatorioComentario')->name('resultComent');

#Dashboard pós login
Route::get('/dashboard', [RatingController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
