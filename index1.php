<?php
require "force_authenticate.php";
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