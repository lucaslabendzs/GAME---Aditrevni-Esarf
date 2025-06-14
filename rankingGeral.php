<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$data_jogo = date('Y-m-d', strtotime('-1 day'));

// Verifica se já foi feito o cálculo do dia anterior
$sql_check = "SELECT COUNT(*) as total FROM DiasCalculados WHERE data_jogo = '$data_jogo'";
$res_check = mysqli_query($conn, $sql_check);
$linha_check = mysqli_fetch_assoc($res_check);

if ($linha_check['total'] == 0) {
    $sql = "SELECT user_id FROM RankingDiario WHERE data_jogo = '$data_jogo' ORDER BY tempo_segundos ASC";
    $result = mysqli_query($conn, $sql);
    $pos = 1;
    while ($linha = mysqli_fetch_assoc($result)) {
        $user_id = $linha['user_id'];
        $pontos = 100 - ($pos - 1);
        // Insere os dados
        $sql2 = "INSERT INTO DiasCalculados (user_id, data_jogo, posicao, pontos)
                 VALUES ($user_id, '$data_jogo', $pos, $pontos)
                 ON DUPLICATE KEY UPDATE posicao=VALUES(posicao), pontos=VALUES(pontos)";
        mysqli_query($conn, $sql2);
        $pos++;
    }
}
// Consulta para ranking geral
$sql_ranking = "SELECT Users.name, SUM(DiasCalculados.pontos) as total_pontos
                FROM DiasCalculados
                JOIN Users ON DiasCalculados.user_id = Users.id
                GROUP BY DiasCalculados.user_id
                ORDER BY total_pontos DESC, Users.name ASC
                LIMIT 100";
$result_ranking = mysqli_query($conn, $sql_ranking);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rankingGeral.css">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
    
    <div class="ranking-container">
        <h1>Ranking Geral(100 melhores)</h1>
    </header>

    <div class="ranking">
    <table>
        <tr>
            <th class="posi">Posição</th>
            <th>Nome</th>
            <th>Pontuação</th>
        </tr>
        <?php
        $posicao = 1;
        while ($linhaDois = mysqli_fetch_assoc($result_ranking)) {
            echo "<tr>
                    <td>{$posicao}</td>
                    <td>{$linhaDois['name']}</td>
                    <td>{$linhaDois['total_pontos']}</td>
                  </tr>";
            $posicao++;
        }
        ?>
    </table>
    </div>
    </div>
    <div class = "botao-ranking">
        <ul>
            <a href="paginaInicial.php">Voltar</a>
        </ul>
    </div>
</body>
</html>