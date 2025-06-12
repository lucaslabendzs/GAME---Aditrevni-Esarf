<?php
require "db_credentials.php";
require "force_authenticate.php";
$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}
date_default_timezone_set('America/Sao_Paulo');
$hoje = date("Y-m-d");
$sql = "SELECT Users.name, RankingDiario.tempo_segundos
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
    <title>Document</title>
    <link rel="stylesheet" href="rankingDiario.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="ranking-container">
        <h1>Ranking Diário</h1>
    </header>

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
            $min = floor($total / 60);
            $seg = floor($total % 60);
            $mil = round(($total - floor($total)) * 100);

            $min = str_pad($min, 2, "0", STR_PAD_LEFT);
            $seg = str_pad($seg, 2, "0", STR_PAD_LEFT);
            $mil = str_pad($mil, 2, "0", STR_PAD_LEFT);
            echo "<tr>
                    <td class='usuario'>$posicao</td>
                    <td>$linha[name]</td>
                    <td>$min:$seg:$mil</td>
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

    <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>