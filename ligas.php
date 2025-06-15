<?php

require "db_credentials.php";
require "force_authenticate.php";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);



if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$sqlMinhasLigas = "SELECT Ligas.id, Ligas.nome, Ligas.descricao 
                   FROM Ligas 
                   INNER JOIN LigaUsuarios ON Ligas.id = LigaUsuarios.liga_id 
                   WHERE LigaUsuarios.user_id = ?";
$stmtMinhas = mysqli_prepare($conn, $sqlMinhasLigas);
mysqli_stmt_bind_param($stmtMinhas, "i", $user_id);
mysqli_stmt_execute($stmtMinhas);
$resultMinhas = mysqli_stmt_get_result($stmtMinhas);

echo "<h2>Minhas Ligas</h2>";
if (mysqli_num_rows($resultMinhas) > 0) {
    while ($liga = mysqli_fetch_assoc($resultMinhas)) {
        echo "<div class='bloco-liga'>";
        echo "<strong>" . htmlspecialchars($liga['nome']) . "</strong><br>";
        echo "<em>" . htmlspecialchars($liga['descricao']) . "</em><br>";
        echo "<a href='pagina_da_liga.php?liga_id=" . $liga['id'] . "' style='margin-top:8px; display:inline-block;'>Acessar Liga</a>";
        echo "</div>";
    }
} else {
    echo "<p>Você ainda não participa de nenhuma liga.</p>";
}
// Se o usuário enviou o formulário para entrar em uma liga
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["liga_id"])) {
    $liga_id = intval($_POST["liga_id"]);
    $palavra_chave = $_POST["palavra_chave"];
    $user_id = $_SESSION["user_id"];

    // Verifica se a palavra-chave está correta
    $sql = "SELECT * FROM Ligas WHERE id = ? AND palavra_chave = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $liga_id, $palavra_chave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Verifica se o usuário já está na liga
        $sql2 = "SELECT * FROM LigaUsuarios WHERE liga_id = ? AND user_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "ii", $liga_id, $user_id);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        if (mysqli_num_rows($result2) == 0) {
            // Adiciona o usuário à liga
            $sql3 = "INSERT INTO LigaUsuarios (liga_id, user_id) VALUES (?, ?)";
            $stmt3 = mysqli_prepare($conn, $sql3);
            mysqli_stmt_bind_param($stmt3, "ii", $liga_id, $user_id);
            mysqli_stmt_execute($stmt3);
            
            header("Location: pagina_da_liga.php?liga_id=" . $liga_id);
            exit();
        } else {
           echo "<div class='mensagem-alerta'>Você já está nesta liga.</div>";
;
        }
    } else {
        echo "<p style='color:red;'>Palavra-chave incorreta!</p>";
    }
}

// Lista todas as ligas
$sql = "SELECT * FROM Ligas";
$result = mysqli_query($conn, $sql);

echo "<h2>Ligas disponíveis</h2>";

$ligasHtml = "";
while ($liga = mysqli_fetch_assoc($result)) {
    $ligasHtml .= "
    <div <div class='form-liga'>
        <strong>" . htmlspecialchars($liga['nome']) . "</strong><br>
        <em>" . htmlspecialchars($liga['descricao']) . "</em><br>
        <form method='post' style='margin-top:8px;'>
            <input type='hidden' name='liga_id' value='" . $liga['id'] . "'>
            <input type='password' name='palavra_chave' placeholder='Palavra-chave' required>
            <input type='submit' value='Entrar na Liga'>
        </form>
    </div>
    ";
}
echo $ligasHtml;

mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ligas.css">
    <title>Ligas</title>
</head>
<body>
    <div>
        <ul>
        <li><a href="criar_ligas.php">Criar ligas</a><li>
        <li><a href="paginaInicial.php">Pagina inicial</a></li>
       </ul>
    </div>   
     <div class="rodape">
        <p>© 2025 Kauan Calegari, Lucas Labendzs, Renan Teles. Todos os direitos reservados.</p>
    </div>

</body>
</html>