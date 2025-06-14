<?php
  require "db_credentials.php";
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


    <div class = "opcoes">
        <div class = "login">
            <a href="login.php">Login</a>
        </div>
        <div class = "registro">
            <a href="register.php">Registrar-se</a>
        </div>
        <div class = "logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class = "tabelas">
        <div class = "RankingDiario">
                <a href="rankingDiario.php">Ranking Diario</a>
            </div>
            <div class = "RankingGeral">
                <a href="rankingGeral.php">Ranking Geral</a>
            </div>
    </div>
    <header class="titulo">
        <h1>Aditrevni esarf</h1>
    </header>
    

    <div class="Titulo_reg">Regras do Jogo:</div>

    <div class="regras" id="regras">
    <ul>
        <li>Escreva a frase invertida o mais rápido possível.</li>
        <li>O jogo termina quando todas as frases forem escritas.</li>
        <li>Não é permitido jogar, e acessar os rankings sem estar logado.</li>
        <li>Divirta-se e desafie seus amigos para ver quem faz mais pontos!</li>
        <li>Cada usuario tem uma jogada por dia! Entao não desperdice a oportunidade!</li>
        <li>Pontuação é realizada, através do ranking diário, no qual apenas os jogadores com menor tempo no dia, ganham pontos para acumular no ranking semanal e geral.</li>
    </ul>
</div>
    <div class="botao-pag">
        <input type="submit" value="Iniciar" id="botao-hom" />
    </div>
    <div>
        <a href="ligas.php">Ligas</a>
    </div>


    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>

 

    <script src="home-pag.js"></script>
</body>
</html>