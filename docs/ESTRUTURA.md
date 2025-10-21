# 📁 Estrutura do Projeto TodoList

Esta documentação explica a organização de pastas e arquivos do projeto, seguindo as convenções do Laravel.

## 🌲 Visão Geral da Estrutura

```
todolist/
├── 📁 app/                     # Código da aplicação
│   ├── 📁 Http/
│   │   └── 📁 Controllers/     # Controladores da API
│   ├── 📁 Models/              # Modelos Eloquent
│   └── 📁 Providers/           # Provedores de serviço
├── 📁 bootstrap/               # Arquivos de inicialização
├── 📁 config/                  # Arquivos de configuração
├── 📁 database/                # Migrações, seeders e factories
│   ├── 📁 factories/
│   ├── 📁 migrations/
│   └── 📁 seeders/
├── 📁 docs/                    # Documentação do projeto
├── 📁 public/                  # Ponto de entrada público
│   └── 📁 build/               # Assets compilados (CSS/JS)
├── 📁 resources/               # Frontend e assets
│   ├── 📁 css/                 # Estilos Tailwind CSS
│   ├── 📁 js/                  # Código Vue.js
│   │   ├── � app.js           # Entrada principal
│   │   └── 📁 components/      # Componentes Vue
│   └── 📁 views/               # Templates Blade
├── 📁 routes/                  # Definição de rotas
├── 📁 storage/                 # Arquivos gerados pela aplicação
├── 📁 tests/                   # Testes automatizados
│   ├── 📁 Feature/
│   └── 📁 Unit/
├── 📁 vendor/                  # Dependências do Composer
├── 📁 node_modules/            # Dependências JavaScript
├── 📄 .env.example             # Exemplo de arquivo de ambiente
├── 📄 .gitignore               # Arquivos ignorados pelo Git
├── 📄 composer.json            # Dependências PHP
├── 📄 package.json             # Dependências JavaScript
├── 📄 vite.config.js           # Configuração do Vite
├── 📄 tailwind.config.js       # Configuração do Tailwind
├── 📄 phpunit.xml              # Configuração do PHPUnit
└── 📄 README.md                # Documentação principal
```

## 📂 Detalhamento das Pastas Principais

### `/app` - Código da Aplicação

O diretório `app` contém o núcleo da aplicação Laravel.

#### `/app/Http/Controllers`
```
Controllers/
└── TarefaController.php        # Controlador principal das tarefas
```

**TarefaController.php** - Gerencia todas as operações CRUD das tarefas:
- `index()` - Lista tarefas com filtros
- `store()` - Cria nova tarefa
- `show()` - Exibe tarefa específica
- `update()` - Atualiza tarefa existente
- `destroy()` - Remove tarefa
- `toggleComplete()` - Alterna status de conclusão

#### `/app/Models`
```
Models/
├── Tarefa.php                  # Model da entidade Tarefa
└── User.php                    # Model padrão do Laravel (usuários)
```

**Tarefa.php** - Representa uma tarefa no banco de dados:
```php
class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao', 
        'concluida',
        'data_vencimento',
        'prioridade'
    ];
    
    protected $casts = [
        'concluida' => 'boolean',
        'data_vencimento' => 'datetime'
    ];
}
```

### `/resources` - Frontend e Assets

#### `/resources/js` - Código Vue.js
```
js/
├── app.js                      # Entrada principal da aplicação
├── bootstrap.js                # Configurações iniciais
└── components/                 # Componentes Vue
    ├── TaskList.vue            # Lista principal de tarefas
    ├── TaskForm.vue            # Formulário de criar/editar
    ├── TaskItem.vue            # Item individual da tarefa
    ├── FilterBar.vue           # Barra de filtros
    └── PriorityBadge.vue       # Badge de prioridade
```

**app.js** - Arquivo principal que inicializa a aplicação Vue:
```javascript
import { createApp } from 'vue';
import TaskList from './components/TaskList.vue';

const app = createApp({});
app.component('task-list', TaskList);
app.mount('#app');
```

#### `/resources/css` - Estilos Tailwind
```
css/
└── app.css                     # Estilos principais com Tailwind
```

**app.css** - Configuração do Tailwind CSS:
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Componentes customizados */
@layer components {
  .task-card {
    @apply bg-white rounded-lg shadow-md p-4 border-l-4 hover:shadow-lg transition-shadow;
  }
  
  .priority-high {
    @apply border-red-500 bg-red-50;
  }
  
  .priority-medium {
    @apply border-yellow-500 bg-yellow-50;
  }
  
  .priority-low {
    @apply border-green-500 bg-green-50;
  }
}
```

#### `/resources/views` - Templates Blade
```
views/
├── home.blade.php              # Página principal da aplicação
└── welcome.blade.php           # Página de boas-vindas
```

**home.blade.php** - Template principal que carrega a aplicação Vue:
```html
<!DOCTYPE html>
<html>
<head>
    <title>TodoList</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <task-list></task-list>
    </div>
</body>
</html>
```

### `/public/build` - Assets Compilados

Após executar `npm run build`, o Vite gera:
```
public/build/
├── manifest.json               # Manifest dos assets
└── assets/
    ├── app.[hash].js           # JavaScript compilado
    └── app.[hash].css          # CSS compilado
```

### `/database` - Estrutura do Banco de Dados

#### `/database/migrations`
```
migrations/
├── 0001_01_01_000000_create_users_table.php          # Tabela de usuários
├── 0001_01_01_000001_create_cache_table.php          # Cache
├── 0001_01_01_000002_create_jobs_table.php           # Jobs
├── 2025_10_15_200014_create_tarefas_table.php        # Tabela principal
├── 2025_10_15_200719_add_fields_to_tarefas_table.php # Campos adicionais
└── 2025_10_16_094218_add_data_vencimento_and_prioridade_to_tarefas_table.php
```

**Estrutura da Tabela `tarefas`:**
```sql
CREATE TABLE tarefas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NULL,
    concluida BOOLEAN DEFAULT FALSE,
    data_vencimento DATE NULL,
    prioridade ENUM('baixa', 'media', 'alta') DEFAULT 'media',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `/routes` - Definição de Rotas

#### `/routes/api.php`
```php
// Rotas da API para tarefas
Route::get('/tarefas', [TarefaController::class, 'index']);        // Listar
Route::post('/tarefas', [TarefaController::class, 'store']);       // Criar
Route::get('/tarefas/{tarefa}', [TarefaController::class, 'show']); // Visualizar
Route::put('/tarefas/{tarefa}', [TarefaController::class, 'update']); // Editar
Route::delete('/tarefas/{tarefa}', [TarefaController::class, 'destroy']); // Excluir
Route::patch('/tarefas/{tarefa}/toggle', [TarefaController::class, 'toggleComplete']); // Toggle
```

### `/tests` - Testes Automatizados

#### Estrutura de Testes
```
tests/
├── 📁 Feature/                 # Testes de funcionalidades (E2E)
│   ├── ConcluirTest.php        # Testes de conclusão de tarefas
│   ├── CriarTest.php           # Testes de criação de tarefas
│   ├── EdicaoTest.php          # Testes de edição de tarefas
│   ├── ExcluirTest.php         # Testes de exclusão de tarefas
│   ├── ListagemTest.php        # Testes de listagem e filtros
│   └── ExampleTest.php         # Teste de exemplo
├── 📁 Unit/                    # Testes unitários
│   └── ExampleTest.php
├── Pest.php                    # Configuração do Pest
└── TestCase.php                # Classe base para testes
```

#### Cobertura de Testes

**ConcluirTest.php** - 13 testes:
- Marcar tarefa como concluída
- Toggle de status (pendente ↔ concluída)
- Preservação de campos ao marcar como concluída
- Casos especiais (sem descrição, sem data, vencida)
- Erros (tarefa inexistente)

**CriarTest.php** - 9 testes:
- Criação com título e descrição
- Validação de campos obrigatórios
- Definição de prioridades
- Valores padrão
- Criação completa com todos os campos

**EdicaoTest.php** - 12 testes:
- Edição individual de campos
- Edição múltipla
- Validações
- Remoção de campos opcionais
- Preservação de campos não enviados

**ListagemTest.php** - 14 testes:
- Listagem básica
- Filtros por estado (pendente/concluída)
- Filtros por prioridade
- Filtros por data
- Filtros combinados
- Visualização de detalhes
- Tratamento de erros

### `/config` - Arquivos de Configuração

```
config/
├── app.php                     # Configurações gerais da aplicação
├── database.php                # Configurações de banco de dados
├── cache.php                   # Configurações de cache
├── session.php                 # Configurações de sessão
└── ...                         # Outros arquivos de configuração
```

### `/docs` - Documentação

```
docs/
├── API.md                      # Documentação completa da API
├── INSTALACAO.md               # Guia de instalação
└── ESTRUTURA.md                # Este arquivo
```

## 🔧 Arquivos de Configuração Importantes

### `composer.json` - Dependências PHP
Define as dependências PHP e configurações do autoloader:

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.9"
    },
    "require-dev": {
        "pestphp/pest": "^2.34",
        "pestphp/pest-plugin-laravel": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

### `package.json` - Dependências JavaScript
Define as dependências do frontend e scripts de build:

```json
{
    "type": "module",
    "devDependencies": {
        "@vitejs/plugin-vue": "^5.0.0",
        "autoprefixer": "^10.4.19",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.38",
        "tailwindcss": "^3.4.0",
        "vite": "^5.0.0",
        "vue": "^3.4.0"
    },
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    }
}
```

### `vite.config.js` - Configuração do Build
Configura o Vite para compilação dos assets:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue(),
    ],
});
```

### `tailwind.config.js` - Configuração do Tailwind
Define as configurações do Tailwind CSS:

```javascript
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                priority: {
                    high: '#ef4444',
                    medium: '#f59e0b',
                    low: '#10b981'
                }
            }
        },
    },
    plugins: [],
}
```

### `phpunit.xml`
Configuração dos testes, incluindo o banco de dados de teste:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="mysql"/>
    <env name="DB_DATABASE" value="todolist_test"/>
    <env name="CACHE_STORE" value="array"/>
    <env name="SESSION_DRIVER" value="array"/>
</php>
```

### `.env` e `.env.testing`
Arquivos de configuração de ambiente:

**.env** - Ambiente de desenvolvimento
**.env.testing** - Ambiente de testes (usa banco separado)

## 📊 Fluxo de Dados Completo

### Frontend → Backend → Database

```
┌─────────────────┐    ┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│  Vue Components │───▶│   HTTP Request  │───▶│  TarefaController │───▶│   Tarefa Model  │
│   (TaskList,    │    │   (Axios/Fetch) │    │     (Laravel)    │    │   (Eloquent)    │
│   TaskForm...)  │    │   JSON/REST     │    │                  │    │                 │
└─────────────────┘    └─────────────────┘    └──────────────────┘    └─────────────────┘
         ▲                       ▲                       │                        │
         │                       │                       │                        ▼
         │                       │                       │                ┌─────────────────┐
         │              ┌─────────────────┐              │                │   MySQL DB      │
         │              │  JSON Response  │              │                │   (tarefas)     │
         └──────────────│  (HTTP Status)  │◀─────────────┘                └─────────────────┘
                        └─────────────────┘
```

### Camadas da Aplicação

```
┌─────────────────────────────────────────────────────────────┐
│                    FRONTEND (Vue.js)                        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │ Components  │  │   Tailwind  │  │    Vite Build       │  │
│  │   (.vue)    │  │    (CSS)    │  │   (Compilation)     │  │
│  └─────────────┘  └─────────────┘  └─────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                              │ HTTP Requests (API)
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    BACKEND (Laravel)                        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │  Routes     │  │ Controllers │  │      Models         │  │
│  │ (api.php)   │  │ (Business)  │  │   (Eloquent)        │  │
│  └─────────────┘  └─────────────┘  └─────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                              │ SQL Queries
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     DATABASE (MySQL)                        │
│             Tabela: tarefas (id, titulo, ...)              │
└─────────────────────────────────────────────────────────────┘
```

## 🧪 Arquitetura de Testes

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│  Feature Tests  │───▶│   HTTP Requests  │───▶│  API Endpoints  │
│   (PestPHP)     │    │   (GET/POST...)  │    │ (Routes + Ctrl) │
└─────────────────┘    └──────────────────┘    └─────────────────┘
                                                        │
                                                        ▼
                                                ┌─────────────────┐
                                                │ Test Database   │
                                                │ (todolist_test) │
                                                └─────────────────┘
```

## 🔄 Convenções Utilizadas

### Nomenclatura Backend
- **Controladores**: PascalCase + "Controller" (`TarefaController`)
- **Models**: PascalCase singular (`Tarefa`)
- **Tabelas**: snake_case plural (`tarefas`)
- **Rotas**: kebab-case (`/api/tarefas`)
- **Métodos**: camelCase (`toggleComplete`)

### Nomenclatura Frontend
- **Componentes Vue**: PascalCase (`TaskList.vue`, `TaskForm.vue`)
- **Props**: camelCase (`taskId`, `isCompleted`)
- **Classes CSS**: kebab-case (`task-item`, `priority-high`)
- **Arquivos**: kebab-case (`task-form.js`)

### Estrutura de Resposta API
```json
{
  "dados": "sempre em camelCase no JSON",
  "created_at": "timestamps em formato ISO 8601",
  "prioridade": "enums em lowercase"
}
```

### Padrões Vue.js
- **Single File Components**: Estrutura `<template>`, `<script>`, `<style>`
- **Composition API**: Uso de `setup()` e funções reativas
- **Props Validation**: Definição de tipos e validação
- **Emits**: Comunicação entre componentes pai/filho

### Padrões Tailwind CSS
- **Utility-First**: Classes utilitárias em vez de CSS customizado
- **Responsive Design**: Prefixos `sm:`, `md:`, `lg:`, `xl:`
- **Component Layer**: `@layer components` para componentes reutilizáveis
- **Design Tokens**: Cores e espaçamentos consistentes

### Padrões de Teste
- **Feature Tests**: Testam funcionalidades completas via HTTP
- **Nomenclatura**: Descrições em português ("usuário pode...")
- **Estrutura**: Arrange, Act, Assert
- **Isolamento**: Cada teste limpa o banco automaticamente

## 📚 Recursos Adicionais

- [Documentação do Laravel](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [PestPHP](https://pestphp.com/)
- [REST API Design](https://restfulapi.net/)

