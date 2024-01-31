<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetDadosCliente;
use Illuminate\Support\Facades\DB;
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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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

Route::get('sync', function () {



    /*
    $employees = \App\Models\Employee::all();
    $count = collect();

    foreach($employees as $employee)
    {
        if($employee->faturas->count() > 0)
        $count[] = collect(['nome' => $employee->name, 'quant' => $employee->faturas->count(), 'setor' => $employee->faturas()->get()]);
    }

    //$pesquisas = \App\Models\Fatura::with('employees')->whereBetween('created_at', ['2024-01-18', '2024-01-19'])->wherePivot('employee_id', 23)->get();

    dd($count);


    foreach ($xclinic_users as $user) {

        \App\Models\Employee::create(
            ['name' => $user->NOME,
                'description_name' => $user->NOME_SOCIAL ?? NULL,
                'x_clinic_id' => $user->USERID],

        );
    }
*/
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/configuracoes/funcionarios', function(){
        return view('settings.employees.index');
    })->name('settings.employees');

    Route::prefix('/relatorios')->group(function(){
        Route::get('/', function (){
            return view('reports.index');
        })->name('reports.index');

        Route::get('/atendimento-usuario', function (){
            return view('reports.report-by-employee');
        })->name('reports.report-by-employee');

        Route::get('/atendimento-setores', function (){
            return view('reports.report-by-sector');
        })->name('reports.report-by-sector');
    });

});


Route::get('comentarios/exportar/', [RatingController::class, 'export'])->name('export.comments');
Route::get('avaliacoes/exportar/', [RatingController::class, 'exportRatings'])->name('export.ratings');

#Selects entre formularios da pesquisa para busca de dados no XClinic
Route::post('GetDadosCliente', GetDadosClienteController::class)->name('GetDadosCliente');
Route::get('/AvaliarEmpresa/{id}', function () {
    return view('rate-ultri');
});
Route::get('/fim', function () {
    return view('fim');
});

#Relatorios
Route::middleware('auth')->group(function () {
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
});

require __DIR__ . '/auth.php';
