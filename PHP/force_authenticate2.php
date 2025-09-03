<?php
  require "authenticate.php";
  //para se o usuario ja estiver logado nao poder acessar algumas paginas(exemplo, login, register)
  if ($login) {
    die("
  <!DOCTYPE html>
  <html lang='en'>
  <head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='CSS/logado.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
    <div class='login-container-2'>
      <h2>Você já está logado!!</h2>
      <a href='paginaInicial.php' class='button-link'>Voltar</a>
    </div>
</body>
</html>
");
}
  ?>
