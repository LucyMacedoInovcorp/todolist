<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $query = Tarefa::query();

        // Filtro por estado (pendente/concluida)
        if ($request->has('estado')) {
            if ($request->estado === 'pendente') {
                $query->where('concluida', false);
            } elseif ($request->estado === 'concluida') {
                $query->where('concluida', true);
            }
        }

        // Filtro por prioridade
        if ($request->has('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        // Filtro por data de vencimento específica
        if ($request->has('data_vencimento')) {
            $query->whereDate('data_vencimento', $request->data_vencimento);
        }

        // Filtro por tarefas vencidas
        if ($request->has('vencidas') && $request->vencidas === 'true') {
            $query->where('data_vencimento', '<', now()->toDateString())
                  ->where('concluida', false);
        }

        $tarefas = $query->orderBy('created_at', 'desc')->get();
        return response()->json($tarefas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'dataVencimento' => 'nullable|date',
            'prioridade' => 'nullable|in:baixa,media,alta',
        ]);

        $tarefa = Tarefa::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_vencimento' => $request->dataVencimento,
            'prioridade' => $request->prioridade ?? 'media',
            'concluida' => false,
        ]);

        return response()->json($tarefa, 201);
    }

    public function show(Tarefa $tarefa)
    {
        return response()->json($tarefa);
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'concluida' => 'sometimes|boolean',
            'dataVencimento' => 'nullable|date',
            'prioridade' => 'nullable|in:baixa,media,alta',
        ]);

        $updateData = $request->only(['titulo', 'descricao', 'concluida', 'prioridade']);
        if ($request->has('dataVencimento')) {
            $updateData['data_vencimento'] = $request->dataVencimento;
        }

        $tarefa->update($updateData);

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
