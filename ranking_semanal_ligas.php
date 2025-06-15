<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Pegue o ID da liga pela URL (?liga_id=1)
$liga_id = isset($_GET['liga_id']) ? intval($_GET['liga_id']) : 0;
if ($liga_id <= 0) {
    die("Liga não especificada.");
}

// Descobre o início da semana (segunda-feira)
$hoje = date('Y-m-d');
$diaSemana = date('N'); // 1 (segunda) a 7 (domingo)
$inicioSemana = date('Y-m-d', strtotime("-" . ($diaSemana - 1) . " days", strtotime($hoje)));

// Consulta: ranking semanal dos usuários da liga
$sql = "
SELECT u.name, SUM(d.pontos) as total_pontos
FROM LigaUsuarios lu
JOIN Users u ON lu.user_id = u.id
JOIN DiasCalculados d ON d.user_id = u.id
WHERE lu.liga_id = $liga_id
  AND d.data_jogo >= '$inicioSemana' AND d.data_jogo <= '$hoje'
GROUP BY u.id
ORDER BY total_pontos DESC, u.name ASC
LIMIT 100
";
$result = mysqli_query($conn, $sql);

// Busca o nome da liga para exibir no título
$sql_liga = "SELECT nome FROM Ligas WHERE id = $liga_id";
$res_liga = mysqli_query($conn, $sql_liga);
$nome_liga = ($row = mysqli_fetch_assoc($res_liga)) ? $row['nome'] : "Liga";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ranking Semanal da Liga <?php echo htmlspecialchars($nome_liga); ?></title>
    <link rel="stylesheet" href="rankingSemanal.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="ranking-container">
            <h1>Ranking Semanal da Liga: <?php echo htmlspecialchars($nome_liga); ?></h1>
        <div class="ranking">
            <table>
                <tr>
                    <th class="posi">Posição</th>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
                <?php
                $posicao = 1;
                while ($linha = mysqli_fetch_assoc($result)) {
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
 <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>
</html>
<?php
mysqli_close($conn);
?>