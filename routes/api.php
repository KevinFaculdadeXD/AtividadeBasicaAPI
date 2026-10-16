<?php
use App\Http\Controllers\TarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('tarefas', TarefaController::class);
Route::get('/pokemon/{nome}', function (string $nome) {
    $response = http::get("https://pokeapi.co/api/v2/pokemon/" . strtolower($nome));

    if ($response->false()) {
        return response()->json(['erro' => 'Pokémon não encontrado'], 404);
    }

    $dados = $response->json();

    return [
        'nome'      =>$dados['name'],
        'altura'    =>$dados['height'],
        'peso'      =>$dados['weight'],
        'tipo'      =>collect($dados['types'])->pluck('type.name'),
        'imagem'    =>$dados['sprites']['front_default'],
    ];
});
