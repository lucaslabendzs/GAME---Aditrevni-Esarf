<?php
require "db_credentials.php";
require "force_authenticate.php";

//verifica se o parametro id da liga foi passado na url
if (!isset($_GET['liga_id'])) {
    die("Liga não especificada.");
}

$liga_id = intval($_GET['liga_id']); // pega o id da url e verifica se eh inteiro
//Conecta ao BD
$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}
//busca o nome da liga pelo id 
$sql = "SELECT nome FROM Ligas WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $liga_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
//se liga encontrada
if ($liga = mysqli_fetch_assoc($result)) {
    $nome_liga = htmlspecialchars($liga['nome']);
} //se nao encontrada, mostra mensagem de erro
else {
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
     <link rel="stylesheet" href="pagina_da_liga.css">
</head>
<body>
    <div class="titulo">
        <h1><?php echo $nome_liga; ?></h1> 
    </div>
    <div class = "opcoes">
        <div class="botao-ranking">
            <a href="rankingLiga.php?liga_id=<?php echo $liga_id; ?>">Ver Ranking Diário da Liga</a>
        </div>
        <div class="botao-ranking">
            <a href="ranking_geral_ligas.php?liga_id=<?php echo $liga_id; ?>">Ver Ranking Geral Liga</a>
        </div>
        <div class="botao-ranking">
            <a href="ranking_semanal_ligas.php?liga_id=<?php echo $liga_id; ?>">Ver Ranking Semanal Liga</a>
        </div>
        <div class="botao-ranking">
        <a href="ligas.php">Voltar</a>
    </div>
    </div> 
    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>
</body>
</html>