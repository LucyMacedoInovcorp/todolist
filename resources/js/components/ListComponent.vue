<template>
    <div class="pagina-principal min-h-screen p-8 flex items-center justify-center">
        <div class="todolist-container">
            <h1 class="text-3xl font-bold mb-8 text-center flex items-center justify-center gap-4">
                <!-- Imagem e título principal -->
                <img src="/images/lapistodolist.png" alt="Lápis TodoList" class="w-12 h-12 icon-destaque">
                Lista de Tarefas
            </h1>
            
            <!-- Conteúdo -->
            <div class="todolist-conteudo space-y-4">
                <!-- Formulário da lista -->
                <div class="flex items-center justify-center">
                    <form @submit.prevent="adicionarTarefa" class="todolist-form">
                        
                        <div class="form-inputs">
                            <input type="text" v-model="novaTarefa.titulo" placeholder="Título da tarefa" class="todolist-input-titulo" />
                            <textarea v-model="novaTarefa.descricao" placeholder="Descrição (opcional)" class="todolist-input-descricao" rows="2"></textarea>
                        </div>
                        <button type="submit" class="todolist-button"><img src="/images/plus.png" alt="Adicionar" class="w-4 h-4"></button>
                    </form>
                </div>
                <!-- Lista de tarefas -->
                <div class="todolist-tarefas min-h-20 conteudo-dinamico rounded-lg px-4 py-3">
                    <div v-if="tarefas.length === 0" class="text-center text-gray-500 italic">
                        Nenhuma tarefa adicionada ainda.
                    </div>
                    
                    <div v-for="tarefa in tarefas" :key="tarefa.id" class="todolist-tarefa mb-4 pb-4 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <!-- Visualização normal -->
                        <div v-if="!tarefa.editando" class="flex items-center justify-between w-full gap-3">
                            <div class="flex items-start gap-3 flex-1">
                                <input 
                                    type="checkbox" 
                                    :checked="tarefa.concluida" 
                                    @change="toggleTarefa(tarefa.id)"
                                    class="progresso mt-1" 
                                />
                                <div class="tarefa-conteudo flex-1">
                                    <h3 
                                        class="tarefa-titulo cursor-pointer" 
                                        :class="{ 'line-through opacity-60': tarefa.concluida }"
                                        @click="editarTarefa(tarefa)"
                                    >
                                        {{ tarefa.titulo }}
                                    </h3>
                                    <p 
                                        v-if="tarefa.descricao" 
                                        class="tarefa-descricao cursor-pointer"
                                        :class="{ 'line-through opacity-60': tarefa.concluida }"
                                        @click="editarTarefa(tarefa)"
                                    >
                                        {{ tarefa.descricao }}
                                    </p>
                                </div>
                            </div>
                            <div class="acoes flex gap-2 ml-auto">
                                <a href="#" @click.prevent="editarTarefa(tarefa)" class="editar">
                                    <img src="/images/lapiseditar.png" alt="Lápis editar" class="w-4 h-4 icon-destaque">
                                </a>
                                <a href="#" @click.prevent="excluirTarefa(tarefa.id)" class="excluir">
                                    <img src="/images/lapisexcluir.png" alt="Lápis excluir" class="w-4 h-4 icon-destaque">
                                </a>
                            </div>
                        </div>

                        <!-- Formulário de edição -->
                        <form v-if="tarefa.editando" @submit.prevent="salvarEdicao(tarefa)" class="editar-tarefa-form">
                            <div class="form-inputs-edicao mb-3">
                                <input 
                                    type="text" 
                                    v-model="tarefa.tituloTemp" 
                                    class="editar-titulo-input mb-2" 
                                    placeholder="Título da tarefa" 
                                />
                                <textarea 
                                    v-model="tarefa.descricaoTemp" 
                                    class="editar-descricao-input" 
                                    placeholder="Descrição" 
                                    rows="2"
                                ></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="todolist-button">
                                    <img src="/images/check.png" alt="Confirmar" class="w-4 h-4">
                                </button>
                                <button type="button" @click="cancelarEdicao(tarefa)" class="todolist-button bg-gray-500">
                                    ✕
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ListComponent',
    data() {
        return {
            tarefas: [],
            novaTarefa: {
                titulo: '',
                descricao: ''
            }
        }
    },
    mounted() {
        this.carregarTarefas();
    },
    methods: {
        async carregarTarefas() {
            try {
                const response = await fetch('/api/tarefas');
                this.tarefas = await response.json();
            } catch (error) {
                console.error('Erro ao carregar tarefas:', error);
            }
        },

        async adicionarTarefa() {
            if (!this.novaTarefa.titulo.trim()) return;

            try {
                const response = await fetch('/api/tarefas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        titulo: this.novaTarefa.titulo,
                        descricao: this.novaTarefa.descricao
                    })
                });

                if (response.ok) {
                    const novaTarefa = await response.json();
                    this.tarefas.unshift(novaTarefa);
                    this.novaTarefa = { titulo: '', descricao: '' };
                }
            } catch (error) {
                console.error('Erro ao adicionar tarefa:', error);
            }
        },

        async toggleTarefa(id) {
            try {
                const response = await fetch(`/api/tarefas/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const tarefaAtualizada = await response.json();
                    const index = this.tarefas.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.tarefas[index] = tarefaAtualizada;
                    }
                }
            } catch (error) {
                console.error('Erro ao alterar status da tarefa:', error);
            }
        },

        editarTarefa(tarefa) {
            tarefa.editando = true;
            tarefa.tituloTemp = tarefa.titulo;
            tarefa.descricaoTemp = tarefa.descricao;
        },

        cancelarEdicao(tarefa) {
            tarefa.editando = false;
            delete tarefa.tituloTemp;
            delete tarefa.descricaoTemp;
        },

        async salvarEdicao(tarefa) {
            try {
                const response = await fetch(`/api/tarefas/${tarefa.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        titulo: tarefa.tituloTemp,
                        descricao: tarefa.descricaoTemp
                    })
                });

                if (response.ok) {
                    const tarefaAtualizada = await response.json();
                    Object.assign(tarefa, tarefaAtualizada);
                    tarefa.editando = false;
                    delete tarefa.tituloTemp;
                    delete tarefa.descricaoTemp;
                }
            } catch (error) {
                console.error('Erro ao salvar edição:', error);
            }
        },

        async excluirTarefa(id) {
            if (!confirm('Tem certeza que deseja excluir esta tarefa?')) return;

            try {
                const response = await fetch(`/api/tarefas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    this.tarefas = this.tarefas.filter(t => t.id !== id);
                }
            } catch (error) {
                console.error('Erro ao excluir tarefa:', error);
            }
        }
    }
}
</script>



