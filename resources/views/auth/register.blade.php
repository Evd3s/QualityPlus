<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QualityPlus+ - Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
            transition: border-color 0.3s ease;
        }
        .register-container input:focus {
            outline: none;
            border-color: #4C00C9;
        }
        .register-container input.error {
            border-color: #e74c3c;
        }
        .register-container input.success {
            border-color: #27ae60;
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
        .register-container button:hover:not(:disabled) {
            background: #37008D;
        }
        .register-container button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .register-container a {
            color: #4C00C9;
            text-decoration: none;
            font-size: 14px;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            text-align: left;
            margin-left: 5%;
        }
        .success-message {
            color: #27ae60;
            font-size: 12px;
            margin-top: 5px;
            text-align: left;
            margin-left: 5%;
        }
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            text-align: left;
            margin-left: 5%;
        }
        .strength-weak { color: #e74c3c; }
        .strength-medium { color: #f39c12; }
        .strength-strong { color: #27ae60; }
        
        .loading {
            display: none;
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="/images/Qualityplus.png" alt="QualityPlus+ Logo">
        
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            
            <input type="text" name="name" id="name" placeholder="Nome completo" required maxlength="255">
            <div id="nameError" class="error-message"></div>
            
            <input type="email" name="email" id="email" placeholder="Email" required maxlength="255">
            <div id="emailError" class="error-message"></div>
            
            <input type="password" name="password" id="password" placeholder="Senha (min. 8 caracteres)" required minlength="8">
            <div id="passwordError" class="error-message"></div>
            <div id="passwordStrength" class="password-strength"></div>
            
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirme a senha" required>
            <div id="confirmError" class="error-message"></div>
            
            @if ($errors->any())
                <div style="color: #e74c3c; font-size: 14px; margin: 10px 0;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            
            <div class="loading" id="loading">Verificando dados...</div>
            
            <button type="submit" id="submitBtn">Registrar</button>
        </form>
        
        <div style="margin-top: 20px; font-size: 14px;">
            Já tem uma conta? <a href="{{ route('login') }}">Conecte-se</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const submitBtn = document.getElementById('submitBtn');
            
            // Validação em tempo real
            nameInput.addEventListener('input', validateName);
            emailInput.addEventListener('input', validateEmail);
            passwordInput.addEventListener('input', validatePassword);
            confirmInput.addEventListener('input', validateConfirmPassword);
            
            function validateName() {
                const name = nameInput.value.trim();
                const nameError = document.getElementById('nameError');
                const nameRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
                
                if (name.length === 0) {
                    showError(nameInput, nameError, '');
                    return false;
                } else if (name.length < 2) {
                    showError(nameInput, nameError, 'Nome deve ter pelo menos 2 caracteres');
                    return false;
                } else if (!nameRegex.test(name)) {
                    showError(nameInput, nameError, 'Nome deve conter apenas letras e espaços');
                    return false;
                } else {
                    showSuccess(nameInput, nameError, '');
                    return true;
                }
            }
            
            function validateEmail() {
                const email = emailInput.value.trim();
                const emailError = document.getElementById('emailError');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const disposableEmails = ['10minutemail.com', 'guerrillamail.com', 'mailinator.com'];
                
                if (email.length === 0) {
                    showError(emailInput, emailError, '');
                    return false;
                } else if (!emailRegex.test(email)) {
                    showError(emailInput, emailError, 'Email inválido');
                    return false;
                } else {
                    const domain = email.split('@')[1];
                    if (disposableEmails.includes(domain)) {
                        showError(emailInput, emailError, 'Email temporário não é permitido');
                        return false;
                    } else {
                        showSuccess(emailInput, emailError, '');
                        return true;
                    }
                }
            }
            
            function validatePassword() {
                const password = passwordInput.value;
                const passwordError = document.getElementById('passwordError');
                const strengthDiv = document.getElementById('passwordStrength');
                
                if (password.length === 0) {
                    showError(passwordInput, passwordError, '');
                    strengthDiv.textContent = '';
                    return false;
                } else if (password.length < 8) {
                    showError(passwordInput, passwordError, 'Senha deve ter pelo menos 8 caracteres');
                    strengthDiv.textContent = '';
                    return false;
                } else {
                    const strength = checkPasswordStrength(password);
                    if (strength.score < 3) {
                        showError(passwordInput, passwordError, 'Senha deve conter: maiúscula, minúscula e número');
                        strengthDiv.textContent = `Força: ${strength.text}`;
                        strengthDiv.className = `password-strength ${strength.class}`;
                        return false;
                    } else {
                        showSuccess(passwordInput, passwordError, '');
                        strengthDiv.textContent = `Força: ${strength.text}`;
                        strengthDiv.className = `password-strength ${strength.class}`;
                        return true;
                    }
                }
            }
            
            function validateConfirmPassword() {
                const confirm = confirmInput.value;
                const password = passwordInput.value;
                const confirmError = document.getElementById('confirmError');
                
                if (confirm.length === 0) {
                    showError(confirmInput, confirmError, '');
                    return false;
                } else if (confirm !== password) {
                    showError(confirmInput, confirmError, 'Senhas não coincidem');
                    return false;
                } else {
                    showSuccess(confirmInput, confirmError, '');
                    return true;
                }
            }
            
            function checkPasswordStrength(password) {
                let score = 0;
                
                if (password.length >= 8) score++;
                if (/[a-z]/.test(password)) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/\d/.test(password)) score++;
                if (/[^a-zA-Z0-9]/.test(password)) score++;
                
                switch(score) {
                    case 0:
                    case 1:
                    case 2:
                        return {score: score, text: 'Fraca', class: 'strength-weak'};
                    case 3:
                    case 4:
                        return {score: score, text: 'Média', class: 'strength-medium'};
                    case 5:
                        return {score: score, text: 'Forte', class: 'strength-strong'};
                    default:
                        return {score: 0, text: 'Fraca', class: 'strength-weak'};
                }
            }
            
            function showError(input, errorDiv, message) {
                input.classList.remove('success');
                input.classList.add('error');
                errorDiv.textContent = message;
                errorDiv.className = 'error-message';
            }
            
            function showSuccess(input, errorDiv, message) {
                input.classList.remove('error');
                input.classList.add('success');
                errorDiv.textContent = message;
                errorDiv.className = 'success-message';
            }
            
            // Validação no envio do formulário
            form.addEventListener('submit', function(e) {
                const loading = document.getElementById('loading');
                
                if (!validateName() || !validateEmail() || !validatePassword() || !validateConfirmPassword()) {
                    e.preventDefault();
                    return;
                }
                
                // Mostra loading e desabilita botão
                loading.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Registrando...';
            });
        });
    </script>
</body>
</html>