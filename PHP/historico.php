<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Pontuação geral
$sql_geral = "SELECT SUM(pontos) as total_geral FROM DiasCalculados WHERE user_id = $user_id";
$res_geral = mysqli_query($conn, $sql_geral);
$total_geral = ($row = mysqli_fetch_assoc($res_geral)) ? $row['total_geral'] : 0;

// Pontuação semanal
$hoje = date('Y-m-d');
$diaSemana = date('N'); // 1 (segunda) a 7 (domingo)
$inicioSemana = date('Y-m-d', strtotime("-" . ($diaSemana - 1) . " days", strtotime($hoje)));
$sql_semanal = "SELECT SUM(pontos) as total_semanal FROM DiasCalculados WHERE user_id = $user_id AND data_jogo >= '$inicioSemana' AND data_jogo <= '$hoje'";
$res_semanal = mysqli_query($conn, $sql_semanal);
$total_semanal = ($row = mysqli_fetch_assoc($res_semanal)) ? $row['total_semanal'] : 0;

// Busca todas as partidas do usuário
$sql = "SELECT data_jogo, tempo_segundos
        FROM RankingDiario
        WHERE user_id = $user_id
        ORDER BY data_jogo DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Partidas</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <div class="historico_css">
        <h1>Histórico de Partidas</h1>
        <div style="margin-bottom: 18px; text-align:center;">
            <strong>Pontuação Geral:</strong> <?php echo ($total_geral ? $total_geral : 0); ?> <br>
            <strong>Pontuação Semanal:</strong> <?php echo ($total_semanal ? $total_semanal : 0); ?>
         </div>
        <table>
            <tr>
                <th>Data</th>
                <th>Tempo</th>
            </tr>
            <?php
            while ($linha = mysqli_fetch_assoc($result)) {
                $total = $linha['tempo_segundos'];
                $min = floor($total / 60);
                $seg = floor($total % 60);
                $mil = round(($total - floor($total)) * 100);

                $min = str_pad($min, 2, "0", STR_PAD_LEFT);
                $seg = str_pad($seg, 2, "0", STR_PAD_LEFT);
                $mil = str_pad($mil, 2, "0", STR_PAD_LEFT);

                echo "<tr>
                        <td>{$linha['data_jogo']}</td>
                        <td>$min:$seg:$mil</td>
                      </tr>";
            }
            ?>
        </table>

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