<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$liga_id = intval($_GET['liga_id']); // Recebe o id da liga pela URL
date_default_timezone_set('America/Sao_Paulo');
$hoje = date("Y-m-d");

// Consulta: pega os usuários da liga e seus tempos do dia
$sql = "SELECT Users.name, RankingDiario.tempo_segundos
        FROM LigaUsuarios
        JOIN Users ON LigaUsuarios.user_id = Users.id
        JOIN RankingDiario ON RankingDiario.user_id = Users.id
        WHERE LigaUsuarios.liga_id = ? AND RankingDiario.data_jogo = ?
        ORDER BY RankingDiario.tempo_segundos ASC
        LIMIT 100";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $liga_id, $hoje);
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
    <title>Ranking Diário da Liga <?php echo htmlspecialchars($nome_liga); ?></title>
    <link rel="stylesheet" href="rankingDiario.css">
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
                    <th>Tempo (s)</th>
                </tr>
                <?php
                $posicao = 1;
                while($linha = mysqli_fetch_assoc($result)) {
                    $total = $linha['tempo_segundos'];
                    $min = floor($total / 60);
                    $seg = floor($total % 60);
                    $mil = round(($total - floor($total)) * 100);

                    $min = str_pad($min, 2, "0", STR_PAD_LEFT);
                    $seg = str_pad($seg, 2, "0", STR_PAD_LEFT);
                    $mil = str_pad($mil, 2, "0", STR_PAD_LEFT);
                    echo "<tr>
                            <td>$posicao</td>
                            <td>{$linha['name']}</td>
                            <td>$min:$seg:$mil</td>
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