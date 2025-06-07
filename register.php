<?php
require "db_functions.php";

$error = false;
$success = false;
$name = $email = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["name"]) && !empty($_POST["email"]) && 
      !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

    // Verifica se o e-mail contém "@"
    if (strpos($email, '@') === false) {
      $error_msg = "Email inválido.";
      $error = true;
    }

    // Só continua se não houve erro de e-mail
    if (!$error) {
      // Verifica se o e-mail já está cadastrado
      $check_sql = "SELECT * FROM $table_users WHERE email ='$email'";
      $result = mysqli_query($conn, $check_sql);

      if (mysqli_num_rows($result) > 0) {
        $error_msg = "Este e-mail já está cadastrado.";
        $error = true;
      } else {
        // Verifica se o nome já está cadastrado
        $check_name_sql = "SELECT * FROM $table_users WHERE name ='$name'";
        $result_name = mysqli_query($conn, $check_name_sql);

        if (mysqli_num_rows($result_name) > 0) {
          $error_msg = "Este nome já está cadastrado.";
          $error = true;
        } else if ($password == $confirm_password) {
          $password = md5($password);

          $sql = "INSERT INTO $table_users
                  (name, email, password) VALUES
                  ('$name', '$email', '$password');";

          if (mysqli_query($conn, $sql)) {
            $success = true;
          } else {
            $error_msg = mysqli_error($conn);
            $error = true;
          }
        } else {
          $error_msg = "Senha não confere com a confirmação.";
          $error = true;
        }
      }
    }

  } else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>[WEB 1] Exemplo Sistema de Login - Registro</title>
</head>
<body>
<h1>Dados para registro de novo usuário</h1>

<?php if ($success): ?>
  <h3 style="color:lightgreen;">Usuário criado com sucesso!</h3>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>

<?php if ($error && !empty($error_msg)): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="register.php" method="post">
  <label for="name">Nome: </label>
  <input type="text" name="name" value="<?php echo $name; ?>" required ><br>

  <label for="email">Email: </label>
  <input type="text" name="email" value="<?php echo $email; ?>"required ><br>
  <?php if (!empty($erro_email)): ?>
    <span style="color:red;"><?php echo $erro_email; ?></span><br>
  <?php endif; ?>

  <label for="password">Senha: </label>
  <input type="password" name="password" value=""required ><br>

  <label for="confirm_password">Confirmação da Senha: </label>
  <input type="password" name="confirm_password" value=""required ><br>

  <input type="submit" name="submit" value="Criar usuário">
</form>

<ul>
  <li><a href="index.php">Voltar</a></li>
</ul>
</body>
</html>
