<?php
require 'db_credentials.php';

// Criando conexão
$conn = mysqli_connect($servername, $username, $db_password);


// check conexão
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cria BD se nao existir
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database criado com sucesso<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// Escolhe o BD
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database escolhido com sucesso<br>";
} else {
    echo "<br>erro ao escolher database: " . mysqli_error($conn);
}

// cria tabela usuarios se nao existir
$sql = "CREATE TABLE IF NOT EXISTS $table_users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(128) NOT NULL,
  created_at DATETIME,
  updated_at DATETIME,
  last_login_at DATETIME,
  last_logout_at DATETIME,
  UNIQUE (email)
)";



if (mysqli_query($conn, $sql)) {
    echo "<br>Table criado com sucesso<br>";
} else {
    echo "<br>erro ao criar database: " . mysqli_error($conn);
}

// |Cria tabela para ranking diario se nao existir
$sql_ranking = "CREATE TABLE IF NOT EXISTS $table_ranking_diario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    tempo_segundos  DECIMAL(8,2) NOT NULL,
    data_jogo DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

if (mysqli_query($conn, $sql_ranking)) {
    echo "<br>Table RankingDiario criado com sucesso<br>";
} else {
    echo "<br>erro ao criar RankingDiario: " . mysqli_error($conn);
}
// Cria tabela dias calculados (utilizado para os rankings semanais e geral) se nao exisitir
$sql_dias = "CREATE TABLE IF NOT EXISTS $table_dias_calculados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    data_jogo DATE NOT NULL,
    posicao INT NOT NULL,
    pontos INT NOT NULL,
    UNIQUE KEY (user_id, data_jogo),
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

if (mysqli_query($conn, $sql_dias)) {
    echo "<br>Table DiasCalculados criado com sucesso<br>";
} else {
    echo "<br>erro ao criar DiasCalculados: " . mysqli_error($conn);
}

// Cria tabela para ligas se nao existir
$sql_ligas = "CREATE TABLE IF NOT EXISTS $table_ligas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT,
    palavra_chave VARCHAR(100) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql_ligas)) {
    echo "<br>Criado liga com sucesso <br>";
} else {
    echo "<br>Erro ao criar:" . mysqli_error($conn);
}
// Cria tabela para associar os usuarios a liga
$sql_liga_usuarios = "CREATE TABLE IF NOT EXISTS LigaUsuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    liga_id INT NOT NULL,
    user_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (liga_id) REFERENCES Ligas(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

if (mysqli_query($conn, $sql_liga_usuarios)) {
    echo "<br>Table LigaUsuarios Criado com sucesso<br>";
} else {
    echo "<br>Erro ao criar liga: " . mysqli_error($conn);
}
//fecha a conexao com o BD
mysqli_close($conn);

?>



