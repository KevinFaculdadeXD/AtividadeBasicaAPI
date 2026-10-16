<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Http\Resources\TarefaResource;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index()
    {
        return TarefaResource::collection(Tarefa::latest()->get());
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo'    => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'concluida' => 'boolean',
        ]);

        return (new TarefaResource(Tarefa::create($dados)))
        ->response()->setStatusCode(201);
    }

    public function show(Tarefa $tarefa)
    {
        return new TarefaResource($tarefa);
    }

    public function update(Request $request, Tarefa $tarefa)
    {
         $dados = $request->validate([
            'titulo'    => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'concluida' => 'boolean',
        ]);
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return response()->noContent(); //204 XD
    }
}
