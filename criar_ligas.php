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
        <a href="ligas.php">Voltar</a>
        <a href="paginaInicial.php">Pagina inicial</a>
    </div>    

</body>
</html>