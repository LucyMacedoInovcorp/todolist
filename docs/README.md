# 📚 Documentação do TodoList API

Bem-vindo à documentação completa do projeto TodoList API! Aqui você encontrará todos os guias necessários para entender, instalar, usar e contribuir com o projeto.

## 📖 Índice da Documentação

### 🚀 Começando
- **[README Principal](../README.md)** - Visão geral do projeto e guia rápido
- **[Guia de Instalação](INSTALACAO.md)** - Passo a passo para configurar o projeto
- **[Guia de Deploy](DEPLOY.md)** - Como fazer deploy para produção

### 🔧 Desenvolvimento
- **[Estrutura do Projeto](ESTRUTURA.md)** - Organização de pastas e arquivos
- **[Documentação da API](API.md)** - Endpoints, parâmetros e exemplos
- **[Guia de Testes](TESTES.md)** - Como executar e criar novos testes

## 🎯 Para Diferentes Personas

### 👩‍💻 **Desenvolvedores Frontend**
Se você vai consumir a API:
1. Leia o [README](../README.md) para entender o projeto
2. Siga o [Guia de Instalação](INSTALACAO.md) para rodar localmente
3. Use a [Documentação da API](API.md) como referência

### 🔧 **Desenvolvedores Backend**
Se você vai modificar ou contribuir:
1. Configure o ambiente com o [Guia de Instalação](INSTALACAO.md)
2. Entenda a [Estrutura do Projeto](ESTRUTURA.md)
3. Aprenda sobre os [Testes](TESTES.md)
4. Consulte a [Documentação da API](API.md)

### 📊 **DevOps/SysAdmin**
Para deployment e infraestrutura:
1. [Guia de Deploy](DEPLOY.md) - Processo completo de deploy
2. [Guia de Instalação](INSTALACAO.md) - Seção "Configuração para Produção"
3. [Estrutura do Projeto](ESTRUTURA.md) - Entender dependências
4. [Guia de Testes](TESTES.md) - Para CI/CD

### 🎨 **Product Managers/QA**
Para entender funcionalidades:
1. [README](../README.md) - Funcionalidades gerais
2. [Documentação da API](API.md) - Detalhes dos recursos
3. [Guia de Testes](TESTES.md) - Cobertura e cenários

## 🚀 Guia Rápido de 5 Minutos

**Quer testar a API rapidamente?**

```bash
# 1. Clone e configure
git clone <repositorio>
cd todolist
composer install
cp .env.example .env
php artisan key:generate

# 2. Configure banco no .env
DB_DATABASE=todolist
DB_USERNAME=root
DB_PASSWORD=sua_senha

# 3. Execute migrações e inicie
php artisan migrate
php artisan serve

# 4. Teste a API
curl http://localhost:8000/api/tarefas
```

## 📚 Arquivos de Documentação

| Arquivo | Descrição | Tamanho | Atualizado |
|---------|-----------|---------|------------|
| [README.md](../README.md) | Documentação principal | ~200 linhas | Recente |
| [INSTALACAO.md](INSTALACAO.md) | Guia de instalação | ~400 linhas | Recente |
| [DEPLOY.md](DEPLOY.md) | Guia de deploy | ~300 linhas | Recente |
| [API.md](API.md) | Documentação da API | ~400 linhas | Recente |
| [ESTRUTURA.md](ESTRUTURA.md) | Estrutura do projeto | ~400 linhas | Recente |
| [TESTES.md](TESTES.md) | Guia de testes | ~450 linhas | Recente |

## 🆘 Precisa de Ajuda?

### Problemas Comuns

**Erro de conexão com banco:**
- Verifique as configurações no `.env`
- Confirme se o MySQL está rodando
- Consulte [INSTALACAO.md](INSTALACAO.md#-resolução-de-problemas-comuns)

**Testes falhando:**
- Verifique se o banco de teste existe
- Execute `php artisan migrate --env=testing`
- Consulte [TESTES.md](TESTES.md#-debug-e-troubleshooting)

**Erro 404 na API:**
- Confirme se o servidor está rodando (`php artisan serve`)
- Verifique as rotas em [API.md](API.md)
- Confirme a base URL: `http://localhost:8000/api`

### Onde Encontrar Informações

| Preciso de... | Consulte... |
|---------------|-------------|
| **Instalar o projeto** | [INSTALACAO.md](INSTALACAO.md) |
| **Usar os endpoints** | [API.md](API.md) |
| **Entender o código** | [ESTRUTURA.md](ESTRUTURA.md) |
| **Executar testes** | [TESTES.md](TESTES.md) |
| **Visão geral** | [README.md](../README.md) |

## 🔄 Mantendo a Documentação Atualizada

Esta documentação deve ser atualizada sempre que:
- Novos endpoints forem adicionados
- Estrutura do projeto mudar
- Novos testes forem criados
- Processo de instalação mudar

### Template para Novas Funcionalidades

Ao adicionar uma nova funcionalidade, atualize:
1. **README.md** - Adicione na lista de funcionalidades
2. **API.md** - Documente novos endpoints
3. **ESTRUTURA.md** - Se houver novos arquivos/pastas
4. **TESTES.md** - Se houver novos testes




