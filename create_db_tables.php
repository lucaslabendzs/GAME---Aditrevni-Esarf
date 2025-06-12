<?php
require 'db_credentials.php';

// Criando conexão
$conn = mysqli_connect($servername, $username, $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// check conexão
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ciando BD
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// Escolhendo o BD
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database changed successfully<br>";
} else {
    echo "<br>Error changing database: " . mysqli_error($conn);
}

// sql to create table user
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
    echo "<br>Table created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// sql to create table rankingDiario
$sql_ranking = "CREATE TABLE IF NOT EXISTS $table_ranking_diario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    tempo_segundos  DECIMAL(8,2) NOT NULL,
    data_jogo DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

if (mysqli_query($conn, $sql_ranking)) {
    echo "<br>Table RankingDiario created successfully<br>";
} else {
    echo "<br>Error creating RankingDiario: " . mysqli_error($conn);
}

mysqli_close($conn)
?>
