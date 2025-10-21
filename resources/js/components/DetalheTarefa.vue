<template>
    <div v-if="mostrar" class="modal-overlay" @click.self="fechar">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-titulo">Detalhes da Tarefa</h2>
                <BotaoUniversal 
                    type="button"
                    variante="subtle-danger" 
                    tamanho="small"
                    icone="/images/excluir.png" 
                    alt-icone="Fechar"
                    @click="fechar"
                />
            </div>
            
            <div class="modal-body">
                <div class="detalhe-item">
                    <label class="detalhe-label">Título:</label>
                    <div class="detalhe-valor">
                        <span :class="{ 'line-through opacity-60': tarefa.concluida }">
                            {{ tarefa.titulo || 'Sem título' }}
                        </span>
                        <span v-if="tarefa.prioridade" :class="['prioridade-badge ml-2', `prioridade-${tarefa.prioridade}`]">
                            {{ formatarPrioridade(tarefa.prioridade) }}
                        </span>
                    </div>
                </div>

                <div v-if="tarefa.descricao" class="detalhe-item">
                    <label class="detalhe-label">Descrição:</label>
                    <div class="detalhe-valor" :class="{ 'line-through opacity-60': tarefa.concluida }">
                        {{ tarefa.descricao }}
                    </div>
                </div>

                <div class="detalhe-item">
                    <label class="detalhe-label">Status:</label>
                    <div class="detalhe-valor">
                        <span :class="tarefa.concluida ? 'status-concluida' : 'status-pendente'">
                            {{ tarefa.concluida ? 'Concluída' : 'Pendente' }}
                        </span>
                    </div>
                </div>

                <div v-if="tarefa.prioridade" class="detalhe-item">
                    <label class="detalhe-label">Prioridade:</label>
                    <div class="detalhe-valor">
                        <span :class="['prioridade-texto', `prioridade-${tarefa.prioridade}`]">
                            {{ getPrioridadeTexto(tarefa.prioridade) }}
                        </span>
                    </div>
                </div>

                <div v-if="tarefa.data_vencimento" class="detalhe-item">
                    <label class="detalhe-label">Data de Vencimento:</label>
                    <div class="detalhe-valor">
                        <span class="vencimento" :class="{ 
                            'vencida': isVencida(tarefa.data_vencimento), 
                            'vence-hoje': venceHoje(tarefa.data_vencimento) 
                        }">
                            📅 {{ formatarData(tarefa.data_vencimento) }}
                        </span>
                    </div>
                </div>

                <div v-if="tarefa.created_at" class="detalhe-item">
                    <label class="detalhe-label">Criada em:</label>
                    <div class="detalhe-valor text-gray-600">
                        {{ formatarDataHora(tarefa.created_at) }}
                    </div>
                </div>

                <div v-if="tarefa.updated_at && tarefa.updated_at !== tarefa.created_at" class="detalhe-item">
                    <label class="detalhe-label">Última atualização:</label>
                    <div class="detalhe-valor text-gray-600">
                        {{ formatarDataHora(tarefa.updated_at) }}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="modal-acoes">
                    <BotaoUniversal 
                        :icone="tarefa.concluida ? '/images/excluir.png' : '/images/check.png'"
                        :alt-icone="tarefa.concluida ? 'Desmarcar' : 'Concluir'"
                        :titulo="tarefa.concluida ? 'Desmarcar como pendente' : 'Marcar como concluída'"
                        :variante="tarefa.concluida ? 'warning' : 'success'"
                        apenas-icone
                        @click="toggleTarefa"
                    />
                    
                    <BotaoUniversal 
                        icone="/images/lapiseditar.png" 
                        alt-icone="Editar" 
                        titulo="Editar tarefa"
                        variante="editar"
                        apenas-icone
                        @click="editarTarefa"
                    />
                    
                    <BotaoUniversal 
                        icone="/images/lapisexcluir.png" 
                        alt-icone="Excluir" 
                        titulo="Excluir tarefa"
                        variante="excluir"
                        apenas-icone
                        @click="excluirTarefa"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BotaoUniversal from './BotaoUniversal.vue';

export default {
    name: 'DetalheTarefa',
    components: {
        BotaoUniversal
    },
    props: {
        tarefa: {
            type: Object,
            required: true,
            default: () => ({})
        },
        mostrar: {
            type: Boolean,
            default: false
        }
    },
    emits: ['fechar', 'editar', 'toggle', 'excluir'],
    methods: {
        fechar() {
            this.$emit('fechar');
        },
        
        editarTarefa() {
            this.$emit('editar', this.tarefa);
            this.fechar();
        },
        
        toggleTarefa() {
            this.$emit('toggle', this.tarefa.id);
            // Não fecha o modal para permitir ver a mudança de status
        },
        
        excluirTarefa() {
            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                this.$emit('excluir', this.tarefa.id);
                this.fechar();
            }
        },
        
        formatarData(data) {
            if (!data) return '';
            
            let date;
            if (data.includes('-')) {
                const [ano, mes, dia] = data.split('-');
                date = new Date(parseInt(ano), parseInt(mes) - 1, parseInt(dia));
            } else {
                date = new Date(data);
            }
            
            if (isNaN(date.getTime())) {
                return 'Data inválida';
            }
            
            return date.toLocaleDateString('pt-BR');
        },
        
        formatarDataHora(dataHora) {
            if (!dataHora) return '';
            
            const date = new Date(dataHora);
            if (isNaN(date.getTime())) {
                return 'Data inválida';
            }
            
            return date.toLocaleString('pt-BR');
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
        },
        
        getPrioridadeTexto(prioridade) {
            const prioridades = {
                'baixa': 'Baixa',
                'media': 'Média',
                'alta': 'Alta'
            };
            return prioridades[prioridade] || prioridade;
        },

        formatarPrioridade(prioridade) {
            const prioridadeMap = {
                'baixa': 'BAIXA',
                'media': 'MÉDIA',
                'alta': 'ALTA'
            };
            return prioridadeMap[prioridade] || prioridade.toUpperCase();
        }
    }
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
}

.modal-content {
    background: white;
    border-radius: 12px;
    max-width: 500px;
    width: 100%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 1.5rem 0;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
}

.modal-titulo {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.modal-close:hover {
    background: #f3f4f6;
}

.modal-body {
    padding: 0 1.5rem 1.5rem;
}

.detalhe-item {
    margin-bottom: 1rem;
}

.detalhe-item:last-child {
    margin-bottom: 0;
}

.detalhe-label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.detalhe-valor {
    color: #6b7280;
    font-size: 1rem;
    line-height: 1.5;
    word-wrap: break-word;
}

.status-concluida {
    color: #10b981;
    font-weight: 500;
}

.status-pendente {
    color: #f59e0b;
    font-weight: 500;
}

.prioridade-badge {
    display: inline-block;
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.prioridade-baixa {
    color: #059669;
}

.prioridade-media {
    color: #d97706;
}

.prioridade-alta {
    color: #dc2626;
}

.prioridade-texto.prioridade-baixa {
    color: #059669;
    font-weight: 500;
}

.prioridade-texto.prioridade-media {
    color: #d97706;
    font-weight: 500;
}

.prioridade-texto.prioridade-alta {
    color: #dc2626;
    font-weight: 500;
}

.vencimento {
    font-weight: 500;
}

.vencida {
    color: #dc2626;
    font-weight: 600;
}

.vence-hoje {
    color: #f59e0b;
    font-weight: 600;
}

.modal-footer {
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.modal-acoes {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.modal-button {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.button-concluir {
    background: #10b981;
    color: white;
}

.button-concluir:hover {
    background: #059669;
}

.button-desmarcar {
    background: #6b7280;
    color: white;
}

.button-desmarcar:hover {
    background: #4b5563;
}

.button-editar {
    background: #3b82f6;
    color: white;
}

.button-editar:hover {
    background: #2563eb;
}

.button-excluir {
    background: #ef4444;
    color: white;
}

.button-excluir:hover {
    background: #dc2626;
}

/* Responsividade */
@media (max-width: 640px) {
    .modal-overlay {
        padding: 0.5rem;
    }
    
    .modal-content {
        max-height: 90vh;
    }
    
    .modal-header {
        padding: 1rem 1rem 0;
        margin-bottom: 1rem;
    }
    
    .modal-body {
        padding: 0 1rem 1rem;
    }
    
    .modal-footer {
        padding: 1rem;
    }
    
    .modal-acoes {
        flex-direction: column;
    }
    
    .modal-button {
        width: 100%;
        justify-content: center;
    }
}
</style>