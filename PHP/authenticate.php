<?php
  //inicia a sessão para ter acesso as variaveis da sessão
  session_start();

    //verifica se o usuario esta logado
  if (isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_email"])) {
    $login = true;
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $user_email = $_SESSION["user_email"];
  }
  else{
    //se nao encontra alguma das variaveis, retorna login como falso e o usuario nao logado
    $login = false;
  }

?>
