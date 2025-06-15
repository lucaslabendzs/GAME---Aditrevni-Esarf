<?php
require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Descobre a data do início da semana (segunda-feira)
$hoje = date('Y-m-d');
$diaSemana = date('N'); // 1 (segunda) a 7 (domingo)
$inicioSemana = date('Y-m-d', strtotime("-" . ($diaSemana - 1) . " days", strtotime($hoje)));

// Consulta para ranking semanal
$sql = "SELECT u.name, SUM(d.pontos) as total_pontos
        FROM DiasCalculados d
        JOIN Users u ON d.user_id = u.id
        WHERE d.data_jogo >= '$inicioSemana' AND d.data_jogo <= '$hoje'
        GROUP BY d.user_id
        ORDER BY total_pontos DESC, u.name ASC
        LIMIT 100";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ranking Semanal</title>
    <link rel="stylesheet" href="rankingSemanal.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Ranking Semanal</h1>
    <table>
        <tr>
            <th>Posição</th>
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
    <a href="paginaInicial.php">Voltar</a>
</body>
</html>
<?php
mysqli_close($conn);
?>