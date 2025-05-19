<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
  $email = trim(strtolower($_POST['email']));
  $senha = $_POST['senha'];

  $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
  $stmt->execute([$email]);
  $usuario = $stmt->fetch();

  if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario'] = $usuario;
    header("Location: dashboard.php");
    exit;
  } else {
    echo "Login inválido.";
  }
}
?>