<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualityPlus</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Cabeçalho personalizado para a Home */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header .logo a {
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }
        header .logo .green {
            color: #00B88A;
        }
        header .logo .blue {
            color: #006BE6;
        }
        header nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        header nav ul li {
            margin-right: 15px;
        }
        /* Estilização dos links do cabeçalho com gradiente */
        header nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 25px;
            background: linear-gradient(to right,rgb(29, 33, 37),rgba(1, 3, 5, 0.59));
            transition: all 0.3s ease;
        }
        header nav ul li a:hover {
            background: linear-gradient(to right,rgb(224, 225, 226),rgb(243, 243, 243));
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="logo">
            <a href="{{ auth()->check() ? route('dashboard') : route('home') }}">
                <span class="green">Quality</span><span class="blue">Plus+</span>
            </a>
        </div>
        <nav>
            <ul>
                <!-- Removido o "Home" -->
                <li><a href="{{ route('login') }}" class="btn-header">Entrar</a></li>
            </ul>
        </nav>
    </header>

    <!-- Seção Principal -->
    <section class="hero">
        <div class="content-box">
            <h2>Cresça seu negócio com <strong>QualityPlus</strong></h2>
            <p>Junte-se a nós para explorar e divulgar o potencial do seu negócio, fazendo-o crescer com a gente.</p>
            <div class="buttons">
                <a href="{{ route('login') }}" class="btn-primary">Entrar</a>
                <a href="#" class="btn-secondary">Mais</a>
            </div>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/business.png') }}" alt="Ilustração de negócios">
        </div>
    </section>

    <!-- Rodapé personalizado -->
    <footer style="background: linear-gradient(to right, #006BE6, #0052cc); color: #fff; padding: 20px; text-align: center;">
        <p>&copy; {{ date('Y') }} QualityPlus. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
