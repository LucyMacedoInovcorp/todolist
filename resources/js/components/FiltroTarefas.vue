<template>
    <div class="todolist-wrapper">
        <div class="filtros-container">
            <div class="filtros-header" @click="toggleFiltros">
                <h3 class="filtros-titulo">
                    Filtrar tarefas:
                    <span class="filtros-contador" v-if="temFiltrosAtivos"> ({{ contadorFiltrosAtivos }})</span>
                </h3>
                <span class="filtros-seta" :class="{ 'rotacionada': filtrosAbertos }">▼</span>
            </div>
            <div class="filtros-grid" v-show="filtrosAbertos" :class="{ 'filtros-expandidos': filtrosAbertos }">
                <!-- Filtro por Estado -->
                <div class="filtro-campo">
                    <label class="filtro-label">Estado:</label>
                    <select :value="filtros.estado" @input="atualizarFiltro('estado', $event.target.value)" class="filtro-select">
                        <option value="todas">Todas</option>
                        <option value="pendentes">Pendentes</option>
                        <option value="concluidas">Concluídas</option>
                    </select>
                </div>
                
                <!-- Filtro por Prioridade -->
                <div class="filtro-campo">
                    <label class="filtro-label">Prioridade:</label>
                    <select :value="filtros.prioridade" @input="atualizarFiltro('prioridade', $event.target.value)" class="filtro-select">
                        <option value="todas">Todas</option>
                        <option value="alta">Alta</option>
                        <option value="media">Média</option>
                        <option value="baixa">Baixa</option>
                    </select>
                </div>
                
                <!-- Filtro por Data -->
                <div class="filtro-campo">
                    <label class="filtro-label">Vencimento:</label>
                    <select :value="filtros.dataVencimento" @input="atualizarFiltro('dataVencimento', $event.target.value)" class="filtro-select">
                        <option value="todas">Todas</option>
                        <option value="vencidas">Vencidas</option>
                        <option value="hoje">Vencem hoje</option>
                        <option value="futuras">Futuras</option>
                    </select>
                </div>
                
                <!-- Botão de Limpar Filtros -->
                <div class="filtro-campo">
                    <BotaoUniversal 
                        variante="warning"
                        tamanho="small"
                        icone="/images/lapisexcluir.png"
                        alt-icone="Limpar"
                        @click="limparFiltros"
                    >
                        Limpar Filtros
                    </BotaoUniversal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BotaoUniversal from './BotaoUniversal.vue';

export default {
    name: 'FiltroTarefas',
    components: {
        BotaoUniversal
    },
    props: {
        filtros: {
            type: Object,
            required: true
        }
    },
    emits: ['atualizar-filtros'],
    data() {
        return {
            filtrosAbertos: false
        }
    },
    computed: {
        temFiltrosAtivos() {
            return this.filtros.estado !== 'todas' || 
                   this.filtros.prioridade !== 'todas' || 
                   this.filtros.dataVencimento !== 'todas';
        },
        contadorFiltrosAtivos() {
            let count = 0;
            if (this.filtros.estado !== 'todas') count++;
            if (this.filtros.prioridade !== 'todas') count++;
            if (this.filtros.dataVencimento !== 'todas') count++;
            return count;
        }
    },
    methods: {
        toggleFiltros() {
            this.filtrosAbertos = !this.filtrosAbertos;
        },
        atualizarFiltro(campo, valor) {
            // Emite evento para o componente pai atualizar os filtros
            this.$emit('atualizar-filtros', { campo, valor });
        },
        
        limparFiltros() {
            // Reseta todos os filtros para 'todas'
            this.$emit('atualizar-filtros', { 
                campo: 'reset', 
                valor: {
                    estado: 'todas',
                    prioridade: 'todas',
                    dataVencimento: 'todas'
                }
            });
        }
    }
}
</script>