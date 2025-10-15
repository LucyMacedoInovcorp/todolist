<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::orderBy('created_at', 'desc')->get();
        return response()->json($tarefas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $tarefa = Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'concluida' => false,
        ]);

        return response()->json($tarefa, 201);
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'concluida' => 'sometimes|boolean',
        ]);

        $tarefa->update($request->only(['titulo', 'descricao', 'concluida']));

        return response()->json($tarefa);
    }

    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return response()->json(['message' => 'Tarefa excluída com sucesso']);
    }

    public function toggleComplete(Tarefa $tarefa)
    {
        $tarefa->update(['concluida' => !$tarefa->concluida]);
        return response()->json($tarefa);
    }
}
