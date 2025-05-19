<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header('Location: dashboard.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>ORLIST - Login</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <form method="POST" action="auth.php" class="login-box">
      <h1>ORLIST</h1>
      <p>Organize seu dia com propósito</p>
      <input type="email" name="email" placeholder="E-mail" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit" name="login">Entrar</button>
    </form>
  </div>
</body>
</html>
