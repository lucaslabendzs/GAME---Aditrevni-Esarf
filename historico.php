<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

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
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="historico_css">
        <h1>Histórico de Partidas</h1>
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