<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
  exit;
}

$usuario = $_SESSION['usuario'];

if (isset($_POST['novo_projeto'])) {
  $nome = $_POST['nome'];
  $stmt = $pdo->prepare("INSERT INTO projetos (nome, usuario_id) VALUES (?, ?)");
  $stmt->execute([$nome, $usuario['id']]);
}

if (isset($_POST['nova_tarefa'])) {
  $titulo = $_POST['titulo'];
  $projeto_id = $_POST['projeto_id'];
  $coluna_id = $_POST['coluna_id'];
  $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, projeto_id, coluna_id) VALUES (?, ?, ?)");
  $stmt->execute([$titulo, $projeto_id, $coluna_id]);
}

$stmt = $pdo->prepare("SELECT * FROM projetos WHERE usuario_id = ?");
$stmt->execute([$usuario['id']]);
$projetos = $stmt->fetchAll();

$colunas = $pdo->query("SELECT * FROM colunas")->fetchAll();

function buscarTarefas($pdo, $projeto_id, $coluna_id) {
  $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE projeto_id = ? AND coluna_id = ?");
  $stmt->execute([$projeto_id, $coluna_id]);
  return $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>OrList - Painel</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h1>Bem-vindo ao OrList, <?= htmlspecialchars($usuario['email']) ?></h1>

    <form method="POST" class="form">
      <input type="text" name="nome" placeholder="Novo projeto" required>
      <button type="submit" name="novo_projeto">Criar Projeto</button>
    </form>

    <?php foreach ($projetos as $projeto): ?>
      <div class="projeto">
        <h2><?= htmlspecialchars($projeto['nome']) ?></h2>

        <form method="POST" class="form-tarefa">
          <input type="hidden" name="projeto_id" value="<?= $projeto['id'] ?>">
          <input type="text" name="titulo" placeholder="Nova tarefa" required>
          <select name="coluna_id" required>
            <?php foreach ($colunas as $coluna): ?>
              <option value="<?= $coluna['id'] ?>"><?= $coluna['nome'] ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit" name="nova_tarefa">Adicionar Tarefa</button>
        </form>

        <div class="kanban">
          <?php foreach ($colunas as $coluna): ?>
            <div class="coluna">
              <h3><?= $coluna['nome'] ?></h3>
              <ul>
                <?php $tarefas = buscarTarefas($pdo, $projeto['id'], $coluna['id']); ?>
                <?php foreach ($tarefas as $tarefa): ?>
                  <li><?= htmlspecialchars($tarefa['titulo']) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>