<?php
require "db_credentials.php";
//função para conectar com o banco de dados utilizando variaveis globais
function connect_db(){
  global $servername, $username, $db_password, $dbname;
  $conn = mysqli_connect($servername, $username, $db_password, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  return($conn);
}
// função para fechar a conexão com o banco de dados
function disconnect_db($conn){
  mysqli_close($conn);
}

?>
