# 📋 TodoList - Aplicação de Gestão de Tarefas

Uma aplicação web simples e intuitiva para gestão de tarefas (lista "To-Do"), desenvolvida seguindo os princípios de design limpo e minimalista.

## 🎯 Visão Geral do Projeto

- **Objetivo**: Criar uma ferramenta eficiente e intuitiva para organização de atividades diárias
- **Público-alvo**: Utilizadores que procuram uma solução prática para gestão de tarefas pessoais
- **Filosofia de Design**: Interface limpa, minimalista e totalmente responsiva
- **Arquitetura**: Aplicação full-stack com separação clara entre backend e frontend


## ✨ Funcionalidades Principais

### � Criação de Tarefas
- **Título e Descrição**: Adicionar novas tarefas com título obrigatório e descrição opcional
- **Data de Vencimento**: Definir prazos para as tarefas com controle de vencimentos
- **Sistema de Prioridades**: Classificação em três níveis (alta, média, baixa) com indicadores visuais
- **Interface Intuitiva**: Formulários simples e validação em tempo real

### 📋 Listagem e Visualização
- **Lista Organizada**: Exibição de todas as tarefas em formato claro e estruturado
- **Filtros Inteligentes**: Filtragem por estado (pendente, concluída, todas), prioridade e data de vencimento
- **Detalhes Expandidos**: Visualização completa ao clicar em qualquer item da lista
- **Hierarquia Visual**: Layout organizado com clara distinção entre elementos

### ✏️ Edição de Tarefas
- **Edição Completa**: Modificação de título, descrição, data de vencimento e prioridade
- **Atualização Dinâmica**: Alterações refletidas instantaneamente na interface
- **Validação Inteligente**: Verificação de dados para garantir integridade das informações

### ✅ Gestão de Estados
- **Marcação de Conclusão**: Mecanismo simples para marcar tarefas como concluídas
- **Toggle de Status**: Alternância rápida entre pendente e concluído
- **Feedback Visual**: Indicadores claros do estado atual de cada tarefa

### �️ Exclusão de Tarefas
- **Remoção Individual**: Exclusão segura de tarefas específicas
- **Confirmação de Ação**: Proteção contra exclusões acidentais

### 📱 Responsividade Total
- **Design Adaptativo**: Interface otimizada para desktop, tablet e mobile
- **Mobile First**: Priorizando a experiência em dispositivos móveis
- **Breakpoints Inteligentes**: Adaptação automática a diferentes tamanhos de ecrã

## 🛠 Stack Tecnológico

### 🔧 Backend (Laravel)
- **Framework**: Laravel 11.x - Estrutura robusta seguindo convenções MVC
- **Linguagem**: PHP 8.2+ - Performance otimizada e recursos modernos
- **Base de Dados**: MySQL 8.0+ - Armazenamento eficiente com índices otimizados
- **ORM**: Eloquent - Gestão elegante de dados e relacionamentos
- **Arquitetura**: Models, Controllers e Migrations organizados
- **Validação**: Validação de dados no backend para integridade das informações
- **Testes**: PestPHP - Cobertura completa com testes unitários e de integração

### 🎨 Frontend (Tailwind CSS)
- **CSS Framework**: Tailwind CSS 3 - Classes utilitárias para estilização moderna
- **Design System**: Componentes reutilizáveis e consistentes
- **Paleta de Cores**: Esquema moderno focado em legibilidade e usabilidade
- **Tipografia**: Fontes legíveis e hierarquia visual clara
- **JavaScript**: Interação básica para componentes dinâmicos
- **Build Tool**: Vite - Compilação rápida e otimizada

### 🚀 Frontend Avançado (Vue.js - Opcional)
- **Framework**: Vue.js 3 
- **Componentes**: Single File Components (SFC) reutilizáveis
- **Reatividade**: Composition API para interações fluidas
- **Integração**: Perfeita harmonia com Tailwind CSS

### 🔧 Ferramentas de Desenvolvimento
- **Gestão de Dependências**: Composer (PHP) + npm (JavaScript)
- **Controle de Versão**: Git com padrão organizado de commits numerados e com descrição
- **Otimização**: Estrutura de pastas seguindo convenções Laravel
- **Performance**: Tempos de carregamento mínimos e responsividade otimizada

## 🚀 Instalação e Configuração

### 📋 Pré-requisitos Técnicos

- **PHP 8.2+** - Runtime do Laravel com recursos modernos
- **Composer** - Gestão de dependências PHP
- **Node.js 18+** - Para compilação de assets frontend
- **MySQL 8.0+** - Base de dados com suporte completo
- **Git** - Controle de versão organizado

### Passo a Passo

1. **Clone o repositório**
   ```bash
   git clone <url-do-repositorio>
   cd todolist
   ```

2. **Instale as dependências**
   ```bash
   # Dependências PHP (Backend)
   composer install
   
   # Dependências JavaScript (Frontend)
   npm install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure o banco de dados**
   
   Edite o ficheiro `.env` com suas configurações:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todolist
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

5. **Execute as migrações**
   ```bash
   php artisan migrate
   ```

6. **Compile os assets do frontend**
   ```bash
   # Desenvolvimento (com hot reload)
   npm run dev
   
   # Ou para produção
   npm run build
   ```

7. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

   A aplicação estará disponível em `http://localhost:8000`
   - **Frontend**: Interface web interativa
   - **API**: Endpoints REST em `/api`

## 📖 Documentação da API

### Base URL
```
http://localhost:8000/api
```

### Endpoints Principais

#### 📋 Listar Tarefas
```http
GET /api/tarefas
```

**Parâmetros de filtro (opcionais):**
- `estado`: `pendente` | `concluida` | `todas`
- `prioridade`: `alta` | `media` | `baixa`  
- `data_vencimento`: `YYYY-MM-DD`
- `vencidas`: `true` | `false`

**Exemplo:**
```bash
curl "http://localhost:8000/api/tarefas?estado=pendente&prioridade=alta"
```

#### ➕ Criar Tarefa
```http
POST /api/tarefas
```

**Body (JSON):**
```json
{
  "titulo": "Minha nova tarefa",
  "descricao": "Descrição da tarefa",
  "dataVencimento": "2025-12-31",
  "prioridade": "alta"
}
```

#### 👁 Visualizar Tarefa
```http
GET /api/tarefas/{id}
```

#### ✏️ Editar Tarefa
```http
PUT /api/tarefas/{id}
```

#### ✅ Alternar Status (Concluída/Pendente)
```http
PATCH /api/tarefas/{id}/toggle
```

#### 🗑️ Excluir Tarefa
```http
DELETE /api/tarefas/{id}
```

### Estrutura de Resposta

```json
{
  "id": 1,
  "titulo": "Minha Tarefa",
  "descricao": "Descrição da tarefa",
  "concluida": false,
  "prioridade": "media",
  "data_vencimento": "2025-12-31T00:00:00.000000Z",
  "created_at": "2025-10-21T10:00:00.000000Z",
  "updated_at": "2025-10-21T10:00:00.000000Z"
}
```

## 🧪 Executando os Testes

### Configuração do Banco de Testes

O projeto usa um banco de dados separado para testes (`todolist_test`). Configure-o:

1. **Crie o banco de teste:**
   ```sql
   CREATE DATABASE todolist_test;
   ```

2. **Execute as migrações no banco de teste:**
   ```bash
   php artisan migrate --env=testing
   ```

### Executar Testes

```bash
# Todos os testes
./vendor/bin/pest

# Testes específicos
./vendor/bin/pest --filter="nome_do_teste"

# Com relatório de cobertura
./vendor/bin/pest --coverage
```

## 🎨 Design e Interface do Utilizador

### 🖌️ Filosofia de Design
- **Estilo Minimalista**: Design limpo e intuitivo seguindo princípios do Tailwind CSS
- **Hierarquia Visual Clara**: Layout organizado e fácil de navegar
- **Foco na Usabilidade**: Interface centrada na experiência do utilizador
- **Acessibilidade**: Seguindo diretrizes WCAG para inclusão digital

### 🎨 Sistema de Design
- **Paleta de Cores**: Esquema moderno e agradável com foco na legibilidade
- **Tipografia Consistente**: Fontes legíveis em toda a aplicação
- **Componentes Reutilizáveis**: Estrutura modular para manutenção e escalabilidade
- **Classes Utilitárias**: Aproveitamento máximo do Tailwind CSS

### 📱 Responsividade Total
```css
/* Exemplos de responsividade com Tailwind */
.task-container {
  @apply w-full md:w-2/3 lg:w-1/2 xl:w-1/3;
  @apply p-4 md:p-6 lg:p-8;
}

.task-item {
  @apply bg-white rounded-lg shadow-md p-4 border-l-4;
  @apply hover:shadow-lg transition-all duration-200;
}

/* Sistema de Prioridades Visual */
.priority-high {
  @apply border-red-500 bg-red-50 text-red-800;
}

.priority-medium {
  @apply border-yellow-500 bg-yellow-50 text-yellow-800;
}

.priority-low {
  @apply border-green-500 bg-green-50 text-green-800;
}
```

### 🔧 Componentes Vue.js (Opcional)

- **TaskList.vue** - Lista principal com filtros inteligentes
- **TaskForm.vue** - Formulário reativo para criação/edição
- **TaskItem.vue** - Componente individual com interações fluidas
- **FilterBar.vue** - Barra de filtros dinâmica
- **PriorityBadge.vue** - Indicador visual de prioridade

### 📐 Adaptação Multi-dispositivo
- **Desktop**: Layout expandido com sidebar e visualização completa
- **Tablet**: Interface otimizada para toque com elementos maiores  
- **Mobile**: Design compacto com navegação por gestos
- **Breakpoints**: sm (640px), md (768px), lg (1024px), xl (1280px)

## 🏗️ Requisitos Técnicos e Arquitetura

### 🔧 Backend Laravel - Estrutura Organizada
- **Convenções Laravel**: Estrutura de pastas dentro dos padrões
- **Models**: Eloquent models para gestão de dados
- **Controllers**: Lógica de negócio organizada e reutilizável
- **Migrations**: Versionamento estruturado da base de dados
- **Validação Robusta**: Integridade de dados garantida no backend
- **API RESTful**: Endpoints padronizados e documentados

### 🎨 Frontend Tailwind - Design System
- **Classes Utilitárias**: Aproveitamento máximo do Tailwind CSS
- **Componentes Modulares**: Estrutura reutilizável e escalável
- **JavaScript Interativo**: Funcionalidades dinâmicas essenciais
- **Performance Otimizada**: Carregamento rápido e responsivo

### 🗄️ Base de Dados MySQL - Estrutura Otimizada
- **Schema Eficiente**: Tabelas otimizadas para performance
- **Índices Estratégicos**: Consultas rápidas e eficientes  
- **Integridade Referencial**: Relacionamentos bem definidos
- **Backup e Segurança**: Proteção de dados implementada

## 🚀 Considerações de Qualidade

### ⚡ Otimização de Performance
- **Tempos de Carregamento Mínimos**: Interface responsiva e rápida
- **Consultas Otimizadas**: Queries eficientes na base de dados
- **Assets Comprimidos**: CSS e JavaScript minificados para produção
- **Caching Inteligente**: Estratégias de cache para melhor performance

### ♿ Acessibilidade e Inclusão
- **Contraste WCAG AA**: Paleta de cores com ratios adequados (✅ Implementado)
- **Labels Semânticos**: Formulários com labels descritivos (✅ Implementado)  
- **Alt Text**: Imagens com texto alternativo apropriado (✅ Implementado)
- **Navegação por Teclado**: Em desenvolvimento - suporte parcial (🚧 Planejado)
- **Atributos ARIA**: Implementação futura para conformidade completa (🔄 Pendente)
- **HTML Semântico**: Estrutura básica implementada, otimizações planeadas (🚧 Em progresso)

> **📝 Nota**: O projeto implementa bases sólidas de acessibilidade, mas ainda não atinge conformidade completa WCAG 2.1 AA. Ver [Guia de Melhorias](docs/ACESSIBILIDADE_MELHORIAS.md) para roadmap detalhado.

### 🧪 Qualidade e Testes
- **Testes Unitários**: Cobertura completa das funcionalidades principais
- **Testes de Integração**: Verificação do fluxo completo da aplicação
- **Validação Contínua**: Garantia de qualidade e estabilidade do código
- **Documentação Técnica**: Guias claros para desenvolvimento e manutenção

### 📝 Versionamento e Deploy
- **Git Organizado**: Padrão consistente de commits e branching
- **Deploy Local**: Desenvolvimento e testes em ambiente local
- **Documentação Completa**: Arquitectura, funcionalidades e implementação
- **Servidor Final**: Migração organizada para ambiente de produção

## 📚 Documentação Completa

Para informações mais detalhadas, consulte a documentação completa em `/docs`:

- **[📖 Índice da Documentação](docs/README.md)** - Navegação completa
- **[🚀 Guia de Instalação](docs/INSTALACAO.md)** - Passo a passo detalhado  
- **[📋 Documentação da API](docs/API.md)** - Endpoints completos com exemplos
- **[� Estrutura do Projeto](docs/ESTRUTURA.md)** - Organização e arquitetura
- **[🧪 Guia de Testes](docs/TESTES.md)** - Como executar e criar testes
- **[🚀 Guia de Deploy](docs/DEPLOY.md)** - Processo de deployment



## 📁 Estrutura Resumida

```
todolist/
├── app/                                         # Backend Laravel
│   ├── Http/Controllers/TarefaController.php    # Controlador principal da API
│   └── Models/Tarefa.php                        # Model da Tarefa
├── resources/                                   # Frontend Assets
│   ├── js/                                      # Código Vue.js
│   │   ├── app.js                               # Entrada principal
│   │   └── components/                          # Componentes Vue
│   ├── css/app.css                              # Estilos Tailwind
│   └── views/                                   # Templates Blade
├── public/                                      # Assets compilados
│   └── build/                                   # Ficheiros gerados pelo Vite
├── docs/                                        # Documentação completa
│   ├── API.md                                   # Documentação da API
│   ├── INSTALACAO.md                            # Guia de instalação
│   ├── ESTRUTURA.md                             # Estrutura do projeto
│   ├── TESTES.md                                # Guia de testes
│   └── README.md                                # Índice da documentação
├── routes/api.php                               # Rotas da API REST
├── tests/Feature/                               # Testes de funcionalidades
├── package.json                                 # Dependências JavaScript
├── vite.config.js                               # Configuração do Vite
├── tailwind.config.js                           # Configuração do Tailwind
└── README.md                                    # Este ficheiro
```
