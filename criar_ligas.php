<?php
require "db_credentials.php";
require "force_authenticate.php";

function verifica_campo($texto){
    $texto = trim($texto);
    $texto = stripslashes($texto);
    $texto = htmlspecialchars($texto);
    return $texto;
}

$conn = mysqli_connect($servername, $username, $db_password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = verifica_campo($_POST['nome']);
    $descricao = verifica_campo($_POST['descricao']);
    $palavra_chave = verifica_campo($_POST['palavra_chave']);

    // Verifica se já existe uma liga com esse nome
    $sql_check = "SELECT id FROM Ligas WHERE nome = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $nome);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $mensagem = "<p style='color:red;'>Já existe uma liga com esse nome!</p>";
    } else {
        // Insere a nova liga
        $sql_insert = "INSERT INTO Ligas (nome, descricao, palavra_chave) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "sss", $nome, $descricao, $palavra_chave);
        if (mysqli_stmt_execute($stmt_insert)) {
            $mensagem = "<p style='color:green;'>Liga criada com sucesso!</p>";
        } else {
            $mensagem = "<p style='color:red;'>Erro ao criar liga.</p>";
        }
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt_check);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Liga</title>
    <link rel="stylesheet" href="criar_ligas.css">
</head>
<body>
  <div class="liga-container">
    <h2>Criar Nova Liga</h2>
    <?php
      if (!empty($mensagem)) {
        echo $mensagem;
      }
    ?>
    <form method="post">
        <label>Nome da Liga:</label>
        <input type="text" name="nome" required>
        <label>Descrição:</label>
        <textarea name="descricao" required></textarea>
        <label>Palavra-chave:</label>
        <input type="password" name="palavra_chave" required>
        <input type="submit" value="Criar Liga">
    </form>
    <a href="ligas.php">Voltar</a>
  </div>
</body>
</html>