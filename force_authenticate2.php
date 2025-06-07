<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="logado.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="login-container">
    <?php
    require "authenticate.php";

    if ($login) {
      die("
  <h2>Você já está logado!!</h2>
  <a href='paginaInicial.php' class='button-link'>Voltar</a>
");
    }
    ?>
  </div>
</body>
</html>