<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualityPlus+ - Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #00B88A, #006BE6);
        }

        .register-container img {
            width: 250px;
            margin-bottom: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 50px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-container h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .register-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-container button {
            width: 96%;
            padding: 10px;
            background: #4C00C9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .register-container button:hover {
            background: #37008D;
        }
        .register-container a {
            color: #4C00C9;
            text-decoration: none;
            font-size: 14px;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="/images/Qualityplus.png" alt="QualityPlus+ Logo">
        <!--<h1>Registrar</h1>-->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Senha" required>
            <input type="password" name="password_confirmation" placeholder="Confirme a senha" required>
            @if ($errors->any())
                <div style="color: red; font-size: 14px;">
                    {{ $errors->first() }}
                </div>
            @endif
            <button type="submit">Registrar</button>
        </form>
        <div style="margin-top: 20px; font-size: 14px;">
            Já tem uma conta? <a href="{{ route('login') }}">Conecte-se</a>
        </div>
    </div>
</body>
</html>
