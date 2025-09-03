<?php
require "db_functions.php";
require "force_authenticate2.php";


$error = false;
$password = $email = "";
// Se o usuário NÃO está logado e o formulário foi enviado via POST
if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
   // Verifica se os campos email e senha foram enviados
  if (isset($_POST["email"]) && isset($_POST["password"])) {

    $conn = connect_db();
    // Escapa caracteres especiais para evitar SQL Injection
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $password = md5($password); //faz as senhas ficaram em hash no BD
    //busca o email o usuario 
    $sql = "SELECT id,name,email,password FROM $table_users
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if($result){
      //verifica se encontrou algum usuário com esse email
      if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        //verifica se a senha está correta
        if ($user["password"] == $password) {
          //Salva dados do usuário na sessão
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["name"];
          $_SESSION["user_email"] = $user["email"];
          //manda pra pagina inicial
          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/paginaInicial.php");
          exit();
        }
        else {
          //exibe esta mensagem caso senha errada
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      }
      else{
        //exibe esta mensagem caso usuario nao seja encontrado no BD
        $error_msg = "Usuário não encontrado!";
        $error = true;
      }
    }
    else {
      //Erro ao consultar BD
      $error_msg = mysqli_error($conn);
      $error = true;
    }
  }
  else {
    //caso campo vazio
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
   <link rel="stylesheet" href="login.css">
</head>
<body>
<h1>Login</h1>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
    <ul>
    <li class="voltar-logado"><a href="paginaInicial.php">Voltar</a></li>
   </ul>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<div class="login-container">
<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="login.php" method="post">
  <label for="email">Email</label>
  <input type="text" name="email" value="<?php echo $email; ?>" required><br>

  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>

  <input type="submit" name="submit" value="Entrar">
</form>

<ul>
  <li><a href="paginaInicial.php">Voltar</a></li>
  <li><a href="register.php">Registrar-se</a></li>
</ul>
</p>
</body>
</html>
