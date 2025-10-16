<template>
    <div class="pagina-principal min-h-screen p-8 flex items-center justify-center">
        <div class="todolist-container">
            <h1 class="text-3xl font-bold mb-8 text-center flex items-center justify-center gap-4">
                <!-- Imagem e título principal -->
                <img src="/images/lapistodolist.png" alt="Lápis TodoList" class="w-12 h-12 icon-destaque">
                Lista de Tarefas
            </h1>
            
            <!-- Conteúdo -->
            <div class="w space-y-4">
                <!-- Formulário da lista -->
                <div class="flex items-center justify-center">
                    <form @submit.prevent="adicionarTarefa" class="todolist-form">
                        
                        <div class="form-inputs">
                            <input type="text" v-model="novaTarefa.titulo" placeholder="Título da tarefa" class="todolist-input-titulo" />
                            <textarea v-model="novaTarefa.descricao" placeholder="Descrição (opcional)" class="todolist-input-descricao" rows="2"></textarea>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Data de Vencimento:</label>
                                    <input type="date" v-model="novaTarefa.dataVencimento" class="todolist-input-date" />
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Prioridade:</label>
                                    <select v-model="novaTarefa.prioridade" class="todolist-input-select">
                                        <option value="baixa">Baixa</option>
                                        <option value="media">Média</option>
                                        <option value="alta">Alta</option>
                                    </select>
                                </div>
                            </div>
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
                                        <span v-if="tarefa.prioridade" :class="['prioridade-badge', `prioridade-${tarefa.prioridade}`]">
                                            {{ tarefa.prioridade.toUpperCase() }}
                                        </span>
                                    </h3>
                                    <p 
                                        v-if="tarefa.descricao" 
                                        class="tarefa-descricao cursor-pointer"
                                        :class="{ 'line-through opacity-60': tarefa.concluida }"
                                        @click="editarTarefa(tarefa)"
                                    >
                                        {{ tarefa.descricao }}
                                    </p>
                                    <div v-if="tarefa.data_vencimento" class="tarefa-meta">
                                        <span class="vencimento" :class="{ 'vencida': isVencida(tarefa.data_vencimento), 'vence-hoje': venceHoje(tarefa.data_vencimento) }">
                                            📅 {{ formatarData(tarefa.data_vencimento) }}
                                        </span>
                                    </div>
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
                        <form v-if="tarefa.editando" @submit.prevent="salvarEdicao(tarefa)" class="editar-tarefa-form flex items-center w-full gap-3">
                            <input 
                                type="checkbox" 
                                :checked="tarefa.concluida" 
                                disabled
                                class="progresso mt-1" 
                            />
                            <div class="form-inputs-edicao flex-1">
                                <input 
                                    type="text" 
                                    v-model="tarefa.tituloTemp" 
                                    class="editar-titulo-input mb-2" 
                                    placeholder="Título da tarefa" 
                                />
                                <textarea 
                                    v-model="tarefa.descricaoTemp" 
                                    class="editar-descricao-input mb-2" 
                                    placeholder="Descrição" 
                                    rows="2"
                                ></textarea>
                                <div class="form-row-edit">
                                    <input type="date" v-model="tarefa.dataVencimentoTemp" class="editar-date-input" />
                                    <select v-model="tarefa.prioridadeTemp" class="editar-select-input">
                                        <option value="baixa">Baixa</option>
                                        <option value="media">Média</option>
                                        <option value="alta">Alta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-2 ml-auto">
                                <button type="submit" class="todolist-button">
                                    <img src="/images/check.png" alt="Confirmar" class="w-4 h-4">
                                </button>
                                <button type="button" @click="cancelarEdicao(tarefa)" class="todolist-button">
                                    <img src="/images/excluir.png" alt="Cancelar" class="w-4 h-4">
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
                descricao: '',
                dataVencimento: '',
                prioridade: 'media'
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
                        descricao: this.novaTarefa.descricao,
                        dataVencimento: this.novaTarefa.dataVencimento,
                        prioridade: this.novaTarefa.prioridade
                    })
                });

                if (response.ok) {
                    const novaTarefa = await response.json();
                    this.tarefas.unshift(novaTarefa);
                    this.novaTarefa = { titulo: '', descricao: '', dataVencimento: '', prioridade: 'media' };
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
            tarefa.dataVencimentoTemp = tarefa.data_vencimento;
            tarefa.prioridadeTemp = tarefa.prioridade || 'media';
        },

        cancelarEdicao(tarefa) {
            tarefa.editando = false;
            delete tarefa.tituloTemp;
            delete tarefa.descricaoTemp;
            delete tarefa.dataVencimentoTemp;
            delete tarefa.prioridadeTemp;
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
                        descricao: tarefa.descricaoTemp,
                        dataVencimento: tarefa.dataVencimentoTemp,
                        prioridade: tarefa.prioridadeTemp
                    })
                });

                if (response.ok) {
                    const tarefaAtualizada = await response.json();
                    Object.assign(tarefa, tarefaAtualizada);
                    tarefa.editando = false;
                    delete tarefa.tituloTemp;
                    delete tarefa.descricaoTemp;
                    delete tarefa.dataVencimentoTemp;
                    delete tarefa.prioridadeTemp;
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
        },

        formatarData(data) {
            if (!data) return '';
            
            let date;
            // Tenta diferentes formatos de data
            if (data.includes('-')) {
                // Formato YYYY-MM-DD (do input date e banco)
                const [ano, mes, dia] = data.split('-');
                date = new Date(parseInt(ano), parseInt(mes) - 1, parseInt(dia));
            } else {
                // Tenta parseamento direto
                date = new Date(data);
            }
            
            // Verifica se a data é válida
            if (isNaN(date.getTime())) {
                return 'Data inválida';
            }
            
            return date.toLocaleDateString('pt-BR');
        },

        isVencida(data) {
            if (!data) return false;
            
            let vencimento;
            if (data.includes('-')) {
                const [ano, mes, dia] = data.split('-');
                vencimento = new Date(parseInt(ano), parseInt(mes) - 1, parseInt(dia));
            } else {
                vencimento = new Date(data);
            }
            
            if (isNaN(vencimento.getTime())) return false;
            
            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);
            vencimento.setHours(0, 0, 0, 0);
            return vencimento < hoje;
        },

        venceHoje(data) {
            if (!data) return false;
            
            let vencimento;
            if (data.includes('-')) {
                const [ano, mes, dia] = data.split('-');
                vencimento = new Date(parseInt(ano), parseInt(mes) - 1, parseInt(dia));
            } else {
                vencimento = new Date(data);
            }
            
            if (isNaN(vencimento.getTime())) return false;
            
            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);
            vencimento.setHours(0, 0, 0, 0);
            return vencimento.getTime() === hoje.getTime();
        }
    }
}
</script>



