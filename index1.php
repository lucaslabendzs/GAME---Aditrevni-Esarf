<?php
require "db_credentials.php";
require "force_authenticate.php";
//consultar se o usuario ja jogou hoje
$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}
$user_id = $_SESSION['user_id'];
date_default_timezone_set('America/Sao_Paulo');
$hoje = date('Y-m-d');

$sql = "SELECT id FROM RankingDiario WHERE user_id = $user_id AND data_jogo = '$hoje'";
$result = mysqli_query($conn, $sql);
$ja_jogou = mysqli_num_rows($result) > 0;
mysqli_close($conn);
if ($ja_jogou === true) {
    header("Location: ja_jogou.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexcopy.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <header class="titulo">
        <h1>Aditrevni esarf</h1>
    </header>
    <div class="frase" id="frase">

    </div>
    <div class="cronometro">
        <h3 id = "counter">00:00:00:00</h3>
    </div>
    <div class="caixa">
        <input type="text" id="caixa-texto" />


    </div>
    <div class="caixa2">
        <input type="submit" value="Enviar palavra" id="botao" />

    </div>

    <div class="ranking">

    </div>

    <div id="local-resposta">

    </div>
    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</P>
    </div>
    <script src="index.js"></script>
</body>

</html>