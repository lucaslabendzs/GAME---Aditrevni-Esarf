<?php
require "db_credentials.php";
require "force_authenticate.php";

// Verifica se o parâmetro liga_id foi passado na URL
if (!isset($_GET['liga_id'])) {
    die("Liga não especificada.");
}

$liga_id = intval($_GET['liga_id']); // pega o id da url e verifica se eh inteiro


$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta para ranking geral da liga
$sql = "SELECT Users.name, SUM(DiasCalculados.pontos) as total_pontos
        FROM LigaUsuarios
        JOIN Users ON LigaUsuarios.user_id = Users.id
        JOIN DiasCalculados ON DiasCalculados.user_id = Users.id
        WHERE LigaUsuarios.liga_id = ?
        GROUP BY Users.id
        ORDER BY total_pontos DESC, Users.name ASC
        LIMIT 100";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $liga_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Busca o nome da liga para exibir no título
$sql_liga = "SELECT nome FROM Ligas WHERE id = $liga_id";
$res_liga = mysqli_query($conn, $sql_liga);
$nome_liga = ($row = mysqli_fetch_assoc($res_liga)) ? $row['nome'] : "Liga";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ranking Geral da Liga <?php echo htmlspecialchars($nome_liga); ?></title>
    <link rel="stylesheet" href="rankingGeral.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="ranking-container">
        <h1>Ranking Semanal da Liga: <?php echo htmlspecialchars($nome_liga); ?></h1>
        <div class="ranking">
            <table>
                <tr>
                    <th>Posição</th>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
                <?php
                $posicao = 1;
                while($linha = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$posicao}</td>
                            <td>{$linha['name']}</td>
                            <td>{$linha['total_pontos']}</td>
                          </tr>";
                    $posicao++;
                }
                ?>
            </table>
        </div>
    </div>
    <div class="botao-ranking">
        <a href="pagina_da_liga.php?liga_id=<?php echo $liga_id; ?>">Voltar</a>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>