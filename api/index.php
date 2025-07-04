<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avalie o Departamento de TI - Novo TempoRH</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #000000; /* Fundo preto */
            color: #ffffff; /* Texto branco */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden; /* Para esconder qualquer barra de rolagem dos elementos de fundo */
            position: relative;
        }

        /* Formas de fundo inspiradas no banner */
        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0; /* Coloca as formas atrás do conteúdo */
        }

        .shape {
            position: absolute;
            background-color: #007769; /* Verde escuro */
            border-radius: 50%;
            opacity: 0.7;
        }

        .shape.light {
            background-color: #77dd77; /* Verde claro */
            opacity: 0.7;
        }

        /* Exemplo de algumas formas - você pode ajustar a posição, tamanho e rotação */
        .shape:nth-child(1) { top: 10%; left: -5%; width: 300px; height: 150px; transform: rotate(-30deg); border-radius: 50% 50% 0 50%; }
        .shape:nth-child(2) { top: 40%; left: 80%; width: 250px; height: 100px; transform: rotate(45deg); border-radius: 50% 0 50% 50%; }
        .shape:nth-child(3) { bottom: 5%; left: 10%; width: 400px; height: 200px; transform: rotate(10deg); border-radius: 0 50% 50% 50%; }
        .shape.light:nth-child(4) { top: 25%; left: 30%; width: 180px; height: 90px; transform: rotate(60deg); border-radius: 50% 0 50% 50%; }
        .shape.light:nth-child(5) { bottom: 20%; right: 5%; width: 350px; height: 170px; transform: rotate(-20deg); border-radius: 50% 50% 50% 0; }


        .container {
            background-color: rgba(255, 255, 255, 0.05); /* Um pouco transparente para manter o tema escuro */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 500px;
            width: 90%;
            z-index: 1; /* Garante que o conteúdo fique sobre as formas */
            backdrop-filter: blur(5px); /* Efeito de vidro fosco */
            -webkit-backdrop-filter: blur(5px); /* Compatibilidade Safari */
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px; /* Ajuste o tamanho da logo se necessário */
            height: auto;
            filter: brightness(0) invert(1); /* Tenta inverter cores para ficar branco */
        }

        h1 {
            color: #77dd77; /* Título em verde claro */
            margin-bottom: 15px;
            font-size: 1.8em;
        }

        p {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #007769; /* Borda verde escuro */
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.3); /* Campo de fundo semi-transparente */
            color: #ffffff;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #77dd77; /* Borda verde claro no foco */
            outline: none;
        }

        .hidden {
            display: none;
        }

        button {
            background-color: #007769; /* Botão verde escuro */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #77dd77; /* Botão verde claro no hover */
        }

        .message {
            margin-top: 20px;
            font-weight: 600;
            padding: 10px;
            border-radius: 5px;
            display: none; /* Escondido por padrão, JavaScript mostrará */
        }

        .message.success {
            background-color: rgba(119, 221, 119, 0.2); /* Verde claro transparente */
            color: #77dd77; /* Verde claro */
            display: block;
        }

        .message.error {
            background-color: rgba(255, 0, 0, 0.2); /* Vermelho transparente */
            color: red; /* Vermelho */
            display: block;
        }

        /* CSS para os botões de rádio de avaliação */
        .rating-options {
            display: flex;
            gap: 10px; /* Espaço entre os botões de rádio */
            margin-top: 10px;
            justify-content: center; /* Centraliza os botões */
            flex-wrap: wrap; /* Permite quebrar linha em telas menores */
            margin-bottom: 20px; /* Espaçamento abaixo das opções de rating */
        }

        .rating-options input[type="radio"] {
            display: none; /* Esconde o input de rádio padrão */
        }

        .rating-options label {
            background-color: #333; /* Fundo escuro para os botões */
            color: #eee; /* Cor do texto */
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border: 1px solid #555; /* Borda sutil */
        }

        .rating-options input[type="radio"]:checked + label {
            background-color: #4CAF50; /* Verde para a opção selecionada */
            color: white;
            border-color: #4CAF50;
        }

        .rating-options label:hover {
            background-color: #555; /* Escurece no hover */
            border-color: #77dd77; /* Borda verde claro no hover */
        }
    </style>
</head>
<body>
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape light"></div>
        <div class="shape light"></div>
    </div>

    <div class="container">
        <div class="logo">
            <svg width="80" height="80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="white" stroke-width="4"/>
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="Montserrat, sans-serif" font-size="35" font-weight="600">NT</text>
            </svg>
        </div>
        <h1>Avalie o Departamento de TI</h1>
        <p>A sua opinião é fundamental para aprimorarmos continuamente nossos serviços e garantir a melhor experiência para todos os colaboradores. Sua avaliação é anônima e nos ajuda a identificar pontos fortes e áreas de melhoria.</p>

        <div id="loginSection">
            <p>Para a organização das avaliações, insira seu usuário e senha para prosseguir:</p>
            <div class="input-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username_field" required>
            </div>
            <div class="input-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password_field" required>
            </div>
            <button id="loginButton">Acessar Avaliação</button>
        </div>

        <div id="evaluationSection" class="hidden">
            <form id="evaluationForm" action="submit.php" method="POST">
                <p>Obrigado por autenticar! Agora, por favor, deixe sua avaliação:</p>
                
                <div class="input-group">
                    <label for="evaluation_field">Sua Avaliação (0 a 5):</label>
                    <div class="rating-options">
                        <?php for ($i = 0; $i <= 5; $i++): ?>
                            <input type="radio" id="evaluation_<?php echo $i; ?>" name="evaluation_field" value="<?php echo $i; ?>" <?php echo ($i == 5) ? 'checked' : ''; ?> required>
                            <label for="evaluation_<?php echo $i; ?>"><?php echo $i; ?></label>
                        <?php endfor; ?>
                    </div>
                </div>
                <input type="hidden" id="hiddenUsername" name="username_field_hidden">
                <input type="hidden" id="hiddenPassword" name="password_field_hidden">

                <button type="submit">Enviar Avaliação</button>
            </form>
            <div class="message" id="responseMessage"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginButton = document.getElementById('loginButton');
            const loginSection = document.getElementById('loginSection');
            const evaluationSection = document.getElementById('evaluationSection');
            const responseMessage = document.getElementById('responseMessage');
            const evaluationForm = document.getElementById('evaluationForm');

            // Lógica para mostrar mensagens de sucesso/erro vindas da URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status && message) {
                responseMessage.textContent = decodeURIComponent(message);
                responseMessage.classList.add(status);
                
                // Se houver uma mensagem, exibe a seção de avaliação.
                // Se for sucesso, esconde o formulário para evitar reenvio.
                loginSection.classList.add('hidden');
                evaluationSection.classList.remove('hidden');
                if (status === 'success') {
                    evaluationForm.classList.add('hidden'); // Esconde o formulário após sucesso
                }
            }


            loginButton.addEventListener('click', () => {
                const usernameInput = document.getElementById('username');
                const passwordInput = document.getElementById('password');
                const hiddenUsername = document.getElementById('hiddenUsername');
                const hiddenPassword = document.getElementById('hiddenPassword');

                const username = usernameInput.value;
                const password = passwordInput.value;

                if (username && password) {
                    // Preenche os campos ocultos do formulário que será submetido via PHP
                    hiddenUsername.value = username;
                    hiddenPassword.value = password;

                    loginSection.classList.add('hidden');
                    evaluationSection.classList.remove('hidden');
                } else {
                    alert('Por favor, preencha seu usuário e senha.');
                }
            });
        });
    </script>
</body>
</html>