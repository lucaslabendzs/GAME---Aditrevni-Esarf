<?php

  require "authenticate.php";

  if($login){
    die("Você já está logado!!
    <ul>
      <li><a href='paginaInicial.php'>Voltar</a></li>
    </ul>
    ");
  }

  
?>
