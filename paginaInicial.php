<?php
  require "authenticate.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <title>Home page</title>
</head>
<body>
    <header class="titulo">
        <h1>Aditrevni arvralap</h1>
    </header>

    <div class="Titulo_reg">Regras do Jogo:</div>

    <div class="regras">
        <textarea id="regras" name="regras" rows="20" cols="100" readonly>
            1. Escreva a frase invertida o mais rápido possível.
            2. O jogo termina quando todas as frases forem escritas.
            3. Não é permitido usar consultas externas ou colar respostas.
            4. Divirta-se e desafie seus amigos para ver quem faz mais pontos!
            5. Pontuação é realizada, através do ranking diario, no qual apenas os 100 jogadores com menor tempo no dia, ganham pontos para acumular no ranking semanal e diario.
        </textarea>
    </div>

    <div class="botao-pag">
        <input type="submit" value="Iniciar" id="botao-hom" />
    </div>

    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>

    <div class = "logout">
     <li><a href="login.php">Login</a></li>
     <li><a href="register.php">Registrar-se</a></li>
     <li><a href="logout.php">Logout</a></li>
    </div>


    <script src="home-pag.js"></script>
</body>
</html>