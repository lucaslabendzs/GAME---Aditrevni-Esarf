<?php
require "authenticate.php";
//para evitar que os usuarios acessem algumas paginas sem estar logado, exibindo o html abaixo
if (!$login) {
  die('
  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="semacesso.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Negado</title>
  </head>
  <body>
    <div class="login-container-3">
      <h2>Você não tem permissão para acessar essa página.</h2>
      <p>Por favor, realize o login para continuar.</p>
      <a href="login.php" class="button-link">Ir para Login</a>
    </div>
  </body>
  </html>');
}
?>