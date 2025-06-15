<?php
require "db_credentials.php";
require "force_authenticate.php";
$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}
$user_id_logado = $_SESSION['user_id'];

// Buscar o tempo do usuário logado para hoje
date_default_timezone_set('America/Sao_Paulo');
$hoje = date("Y-m-d");
$sql_meu_tempo = "SELECT tempo_segundos FROM RankingDiario WHERE user_id = $user_id_logado AND data_jogo = '$hoje'";
$res_meu_tempo = mysqli_query($conn, $sql_meu_tempo);
$meu_tempo = null;
if ($linha = mysqli_fetch_assoc($res_meu_tempo)) {
    $total = $linha['tempo_segundos'];
    $min = str_pad(floor($total / 60), 2, "0", STR_PAD_LEFT);
    $seg = str_pad(floor($total % 60), 2, "0", STR_PAD_LEFT);
    $mil = str_pad(round(($total - floor($total)) * 100), 2, "0", STR_PAD_LEFT);
    $meu_tempo = "$min:$seg:$mil";
} else {
    $meu_tempo = "Você ainda não jogou hoje!";
}

// Ranking diário
$sql = "SELECT Users.id, Users.name, RankingDiario.tempo_segundos
        FROM RankingDiario
        JOIN Users ON RankingDiario.user_id = Users.id
        WHERE RankingDiario.data_jogo = '$hoje'
        ORDER BY RankingDiario.tempo_segundos ASC
        LIMIT 100;";
$result = mysqli_query($conn, $sql);    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Diário</title>
    <link rel="stylesheet" href="rankingDiario.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="ranking-container">
        <h1>Ranking Diário</h1>
        <div class="meu-tempo-info">
            Seu tempo hoje: <strong><?php echo $meu_tempo; ?></strong>
        </div>
        <div class="ranking">
            <table>
                <tr>
                    <th class="posi">Posição</th>
                    <th>Nome</th>
                    <th>Tempo (s)</th>
                </tr>
                <?php
                $posicao = 1;
                while($linha = mysqli_fetch_assoc($result)) {
                    $total = $linha['tempo_segundos'];
                    $min = str_pad(floor($total / 60), 2, "0", STR_PAD_LEFT);
                    $seg = str_pad(floor($total % 60), 2, "0", STR_PAD_LEFT);
                    $mil = str_pad(round(($total - floor($total)) * 100), 2, "0", STR_PAD_LEFT);

                    // Destaca a linha do usuário logado
                    $classe = ($linha['id'] == $user_id_logado) ? "meu-tempo" : "";

                    echo "<tr class='$classe'>
                            <td class='usuario'>$posicao</td>
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
        <a href="paginaInicial.php">Voltar</a>
    </div>

    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>