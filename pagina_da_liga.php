<?php
require "db_credentials.php";
require "force_authenticate.php";

if (!isset($_GET['liga_id'])) {
    die("Liga não especificada.");
}

$liga_id = intval($_GET['liga_id']);

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$sql = "SELECT nome FROM Ligas WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $liga_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($liga = mysqli_fetch_assoc($result)) {
    $nome_liga = htmlspecialchars($liga['nome']);
} else {
    $nome_liga = "Liga não encontrada";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nome_liga; ?></title>
</head>
<body>
   <h1><?php echo $nome_liga; ?></h1> 
   <div class="botao-ranking">
    <a href="rankingLiga.php?liga_id=<?php echo $liga_id; ?>">Ver Ranking Diário da Liga</a>
</div>
 <div class="botao-ranking">
    <a href="ranking_geral_ligas.php?liga_id=<?php echo $liga_id; ?>">Ranking geral ligas</a>
</div>
</body>
</html>