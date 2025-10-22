<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Aplicação web para gestão de tarefas com design acessível e inclusivo. Organize suas tarefas de forma eficiente e acessível.">
    <meta name="keywords" content="todolist, tarefas, gestão, acessibilidade, organização">
    <meta name="author" content="TodoList App">
    <title>TodoList - Gestão de Tarefas Acessível</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

</head>
<body>
    <!-- Skip Links -->
    <a href="#main-content" class="skip-link">
        Ir para o conteúdo principal
    </a>
    <a href="#navigation" class="skip-link">
        Ir para a navegação
    </a>
    
    <div id="app">
        <!-- Header -->
        <header role="banner" id="navigation">
            <nav role="navigation" aria-label="Navegação principal">                
            </nav>
        </header>

        <!-- Conteúdo -->
        <main id="main-content" role="main" tabindex="-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer role="contentinfo">
            
        </footer>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>