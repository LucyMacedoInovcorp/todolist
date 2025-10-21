# 🔧 Melhorias de Acessibilidade Necessárias

## 🎯 Status Atual vs WCAG 2.1

### ❌ **Não Conforme** - Implementações Necessárias

#### 1. **Atributos ARIA Obrigatórios**

**BotaoUniversal.vue - Versão Acessível:**
```vue
<template>
    <component 
        :is="elementType"
        :type="elementType === 'button' ? type : undefined"
        :class="classes"
        :title="titulo"
        :disabled="disabled"
        :aria-label="ariaLabel || titulo"
        :aria-describedby="ariaDescribedby"
        :aria-pressed="ariaPressedValue"
        :tabindex="computedTabIndex"
        @click="handleClick"
        @keydown.enter="handleEnter"
        @keydown.space="handleSpace"
    >
        <img 
            v-if="icone" 
            :src="icone" 
            :alt="altIcone" 
            :aria-hidden="apenasIcone ? 'false' : 'true'"
            class="w-3 h-3"
        >
        <span v-if="!apenasIcone" :aria-hidden="false">
            <slot></slot>
        </span>
    </component>
</template>

<script>
export default {
    props: {
        // ... props existentes
        ariaLabel: String,
        ariaDescribedby: String,
        ariaPressedValue: Boolean,
        skipTabIndex: Boolean
    },
    computed: {
        computedTabIndex() {
            if (this.disabled) return -1;
            if (this.skipTabIndex) return -1;
            return 0;
        }
    },
    methods: {
        handleEnter(event) {
            if (!this.disabled) {
                this.handleClick(event);
            }
        },
        handleSpace(event) {
            event.preventDefault();
            if (!this.disabled) {
                this.handleClick(event);
            }
        }
    }
}
</script>
```

#### 2. **Componente Lista com Acessibilidade**

**ListComponent.vue - Melhorias:**
```vue
<template>
    <div class="todolist-container" role="main" aria-label="Aplicação de Gestão de Tarefas">
        <header role="banner">
            <h1 id="page-title">
                <img src="/images/lapistodolist.png" 
                     alt="" 
                     aria-hidden="true" 
                     class="w-12 h-12 icon-destaque">
                TodoList
            </h1>
        </header>

        <!-- Formulário com acessibilidade -->
        <form @submit.prevent="adicionarTarefa" 
              role="form" 
              aria-labelledby="form-title"
              aria-describedby="form-description">
            
            <fieldset>
                <legend id="form-title" class="sr-only">Adicionar Nova Tarefa</legend>
                <p id="form-description" class="sr-only">
                    Preencha os campos abaixo para criar uma nova tarefa
                </p>

                <div class="form-group">
                    <label for="titulo-tarefa" class="form-label">
                        Título da Tarefa <span aria-label="obrigatório">*</span>
                    </label>
                    <input 
                        id="titulo-tarefa"
                        v-model="novaTarefa.titulo"
                        type="text"
                        required
                        aria-required="true"
                        aria-describedby="titulo-help"
                        :aria-invalid="errors.titulo ? 'true' : 'false'"
                        class="form-input"
                    >
                    <div v-if="errors.titulo" 
                         id="titulo-help" 
                         role="alert" 
                         class="error-message">
                        {{ errors.titulo }}
                    </div>
                </div>
            </fieldset>
        </form>

        <!-- Lista de tarefas com navegação -->
        <section role="region" 
                 aria-labelledby="tasks-heading"
                 aria-describedby="tasks-count">
            
            <h2 id="tasks-heading">Lista de Tarefas</h2>
            <p id="tasks-count" class="sr-only">
                {{ tarefas.length }} tarefas no total, 
                {{ tarefasPendentes }} pendentes
            </p>

            <!-- Anúncio de mudanças para screen readers -->
            <div aria-live="polite" 
                 aria-atomic="true" 
                 class="sr-only">
                {{ statusMessage }}
            </div>

            <ul role="list" class="task-list">
                <li v-for="tarefa in tarefas" 
                    :key="tarefa.id"
                    role="listitem"
                    :aria-labelledby="`task-${tarefa.id}-title`"
                    :aria-describedby="`task-${tarefa.id}-meta`"
                    class="task-item">
                    
                    <h3 :id="`task-${tarefa.id}-title`" class="task-title">
                        {{ tarefa.titulo }}
                    </h3>
                    
                    <div :id="`task-${tarefa.id}-meta`" class="task-meta">
                        <span class="sr-only">Estado:</span>
                        <span :class="estadoClass(tarefa)">
                            {{ tarefa.concluida ? 'Concluída' : 'Pendente' }}
                        </span>
                        <span class="sr-only">Prioridade:</span>
                        <span :class="prioridadeClass(tarefa)">
                            {{ formatarPrioridade(tarefa.prioridade) }}
                        </span>
                    </div>

                    <!-- Botões com acessibilidade -->
                    <div class="task-actions" role="group" 
                         :aria-labelledby="`task-${tarefa.id}-actions`">
                        
                        <span :id="`task-${tarefa.id}-actions`" class="sr-only">
                            Ações para tarefa {{ tarefa.titulo }}
                        </span>

                        <BotaoUniversal
                            :aria-label="tarefa.concluida ? 
                                'Marcar como pendente' : 
                                'Marcar como concluída'"
                            :aria-describedby="`task-${tarefa.id}-title`"
                            @click="toggleComplete(tarefa.id)"
                        >
                            {{ tarefa.concluida ? 'Desmarcar' : 'Concluir' }}
                        </BotaoUniversal>
                    </div>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            statusMessage: '',
            // ... outros dados
        }
    },
    computed: {
        tarefasPendentes() {
            return this.tarefas.filter(t => !t.concluida).length;
        }
    },
    methods: {
        toggleComplete(id) {
            const tarefa = this.tarefas.find(t => t.id === id);
            const novoEstado = !tarefa.concluida;
            
            // Atualizar tarefa...
            
            // Anunciar mudança
            this.statusMessage = `Tarefa "${tarefa.titulo}" ${
                novoEstado ? 'marcada como concluída' : 'marcada como pendente'
            }`;
            
            // Limpar mensagem após 3 segundos
            setTimeout(() => {
                this.statusMessage = '';
            }, 3000);
        }
    }
}
</script>
```

#### 3. **CSS para Screen Readers**

```css
/* Classes utilitárias para acessibilidade */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Focus visível para navegação por teclado */
button:focus,
input:focus,
select:focus,
a:focus {
    outline: 2px solid #2563EB;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
}

/* Estados de erro claramente visíveis */
[aria-invalid="true"] {
    border-color: #DC2626;
    box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
}

/* Garantir contraste adequado */
.error-message {
    color: #DC2626;
    background: #FEF2F2;
    border: 1px solid #FECACA;
    padding: 0.5rem;
    border-radius: 4px;
}

/* Estados hover com contraste adequado */
.task-item:hover {
    background: #F9FAFB;
    border-color: #D1D5DB;
}

.task-item:focus-within {
    background: #EFF6FF;
    border-color: #3B82F6;
}
```

#### 4. **Verificação de Contraste WCAG**

**Ratios Atuais:**
- `#111827` sobre `#FFFFFF`: **15.8:1** ✅ (AAA)
- `#6B7280` sobre `#FFFFFF`: **5.9:1** ✅ (AA)  
- `#2563EB` sobre `#FFFFFF`: **8.6:1** ✅ (AAA)

**Melhorias Necessárias:**
- Links em estado hover/focus
- Estados de erro e validação
- Badges de prioridade

#### 5. **HTML Semântico Melhorado**

```html
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList - Gestão de Tarefas Acessível</title>
    <meta name="description" content="Aplicação web para gestão de tarefas com design acessível e inclusivo">
</head>
<body>
    <!-- Skip to main content link -->
    <a href="#main-content" class="skip-link">
        Ir para o conteúdo principal
    </a>
    
    <div id="app">
        <main id="main-content" tabindex="-1">
            @yield('content')
        </main>
    </div>
</body>
</html>
```

## 🎯 **Checklist de Implementação**

### Imediato (Crítico):
- [ ] Adicionar atributos ARIA obrigatórios
- [ ] Implementar navegação por teclado  
- [ ] Criar mensagens para screen readers
- [ ] Adicionar focus indicators visíveis

### Médio Prazo:
- [ ] Testar com leitores de ecrã (NVDA, JAWS)
- [ ] Validar contraste com ferramentas automáticas
- [ ] Implementar skip links
- [ ] Adicionar legendas/descriptions contextuais

### Longo Prazo:
- [ ] Certificação WCAG 2.1 AA formal
- [ ] Testes com utilizadores com deficiências
- [ ] Documentação de acessibilidade
- [ ] Formação da equipa em práticas inclusivas

## 🛠️ **Ferramentas de Teste Recomendadas**

1. **axe-core** - Testes automáticos de acessibilidade
2. **WAVE** - Web Accessibility Evaluation Tool  
3. **Lighthouse** - Auditoria de acessibilidade
4. **Screen Readers**: NVDA (gratuito), JAWS
5. **Contrast Checker** - WebAIM

