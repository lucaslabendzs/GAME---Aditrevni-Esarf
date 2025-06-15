<?php
require "db_credentials.php";
require "authenticate.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $palavra_chave = $_POST["palavra_chave"];
    $user_id = $_SESSION["user_id"]; // Certifique-se que o usuário está logado

    // Conexão com o banco
    $conn = mysqli_connect($servername, $username, $db_password, $dbname);

    if (!$conn) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

    // Insere a liga
    $sql = "INSERT INTO Ligas (nome, descricao, palavra_chave) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nome, $descricao, $palavra_chave);

    if (mysqli_stmt_execute($stmt)) {
        $liga_id = mysqli_insert_id($conn);
        // Associa o criador à liga
        $sql2 = "INSERT INTO LigaUsuarios (liga_id, user_id) VALUES (?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "ii", $liga_id, $user_id);
        mysqli_stmt_execute($stmt2);

        echo "<p style='color:green;'>Liga criada com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao criar liga: " . mysqli_error($conn) . "</p>";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar ligas</title>
</head>
<body>
      <h2>Criar nova liga</h2>
    
      <div>
      <form action="criar_ligas.php" method="post">
        <label for="nome">Nome da Liga:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao"></textarea><br><br>

        <label for="palavra_chave">Palavra-chave:</label><br>
        <input type="password" id="palavra_chave" name="palavra_chave" required><br><br>

        <input type="submit" value="Criar Liga">
    </form>   
</div>

     <div>
        <ul>
          <li><a href="ligas.php">Voltar</a></li>
          <li><a href="paginaInicial.php">Pagina inicial</a></li>
       </ul>
    </div>    

</body>
</html>