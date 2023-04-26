<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Avaliacao;
use Symfony\Component\Finder\Finder;

class AvaliacaoController extends Controller
{


    public function __construct()
    {

    }

    public function create()
    {

        return view('welcome');
    }
    public function store(Request $request)
    {
    }

    public function edit(Avaliacao $id)
    {
        $avaliacao = Avaliacao::find($id);

        return view('avaliar', compact('avaliacao'));
    }

    public function editAgenda(Avaliacao $id)
    {
        $avaliacao = Avaliacao::find($id);

        return view('agenda-data', compact('agendas'));
    }



    public function update(Request $request)
    {

    }
}
