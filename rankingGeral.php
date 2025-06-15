<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Define a data de ontem
$data_jogo = date('Y-m-d', strtotime('-1 day'));

// Busca todos os usuários que jogaram ontem, ordenados pelo tempo
$sql = "SELECT user_id FROM RankingDiario WHERE data_jogo = '$data_jogo' ORDER BY tempo_segundos ASC";
$result = mysqli_query($conn, $sql);

$pos = 1;
while ($linha = mysqli_fetch_assoc($result)) {
    $user_id = $linha['user_id'];

    // Verifica se já existe registro desse usuário para ontem em DiasCalculados
    $sql_check_user = "SELECT COUNT(*) as total FROM DiasCalculados WHERE user_id = $user_id AND data_jogo = '$data_jogo'";
    $res_check_user = mysqli_query($conn, $sql_check_user);
    $linha_check_user = mysqli_fetch_assoc($res_check_user);

    if ($linha_check_user['total'] == 0) {
        $pontos = 100 - ($pos - 1);
        $sql2 = "INSERT INTO DiasCalculados (user_id, data_jogo, posicao, pontos)
                 VALUES ($user_id, '$data_jogo', $pos, $pontos)";
        mysqli_query($conn, $sql2);
    }
    $pos++;
}

// Agora exibe o ranking geral normalmente
$sql_ranking = "SELECT u.name, SUM(d.pontos) as total_pontos
                FROM DiasCalculados d
                JOIN Users u ON d.user_id = u.id
                GROUP BY d.user_id
                ORDER BY total_pontos DESC, u.name ASC
                LIMIT 100";
$result_ranking = mysqli_query($conn, $sql_ranking);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ranking Geral</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="rankingGeral.css">
</head>
<body>
    <div class="ranking-container">
            <h1>Ranking Geral (100 melhores)</h1>
        <div class="ranking">
            <table>
                <tr>
                    <th class="posi">Posição</th>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
                <?php
                $posicao = 1;
                while ($linha = mysqli_fetch_assoc($result_ranking)) {
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
        <a href="paginaInicial.php">Voltar</a>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>