<?php
try {
  $pdo = new PDO("mysql:host=localhost;dbname=orlist", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "✅ Conexão com banco de dados funcionando!";
} catch (PDOException $e) {
  echo "❌ Erro na conexão: " . $e->getMessage();
}
