<?php
include '../config/connect.php';


if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}


if (!isset($_GET['tema_id'])) {
    header('Location: index.php'); 
    exit;
}

$tema_id = (int)$_GET['tema_id'];


$sql_tema = "SELECT nome FROM temas WHERE id = :id";
$stmt_t = $conn->prepare($sql_tema);
$stmt_t->execute([':id' => $tema_id]);
$tema = $stmt_t->fetch(PDO::FETCH_ASSOC);

if (!$tema) {
    die("Tema não encontrado.");
}


$sql_perguntas = "SELECT * FROM perguntas WHERE tema_id = :tema_id ORDER BY id DESC";
$stmt_p = $conn->prepare($sql_perguntas);
$stmt_p->execute([':tema_id' => $tema_id]);
$perguntas = $stmt_p->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Perguntas</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; font-size: 14px; }
        .btn-add { background: #28a745; display: inline-block; margin-bottom: 15px; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-del { background: #dc3545; }
        .btn-resp { background: #17a2b8; }
    </style>
</head>
<body>
    <div style="max-width: 900px; margin: auto;">
        <h1>Perguntas do Tema: <?php echo htmlspecialchars($tema['nome']); ?></h1>
        
        <a href="index.php">⬅ Voltar para Temas</a> | 
        <a href="form_pergunta.php?tema_id=<?php echo $tema_id; ?>" class="btn btn-add">➕ Adicionar Nova Pergunta</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perguntas as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['texto_pergunta']); ?></td>
                    <td>
                        <a href="respostas.php?pergunta_id=<?php echo $p['id']; ?>" class="btn btn-resp">Respostas</a>
                        
                        <a href="form_pergunta.php?id=<?php echo $p['id']; ?>&tema_id=<?php echo $tema_id; ?>" class="btn btn-edit">Editar</a>
                        
                        <a href="excluir_pergunta.php?id=<?php echo $p['id']; ?>&tema_id=<?php echo $tema_id; ?>" 
                           class="btn btn-del" 
                           onclick="return confirm('Excluir esta pergunta e todas as suas respostas?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (count($perguntas) == 0): ?>
                    <tr><td colspan="3">Nenhuma pergunta cadastrada para este tema.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>