<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$pergunta_id = (int)$_GET['pergunta_id'];


$sql_p = "SELECT * FROM perguntas WHERE id = :id";
$stmt_p = $conn->prepare($sql_p);
$stmt_p->execute([':id' => $pergunta_id]);
$pergunta = $stmt_p->fetch(PDO::FETCH_ASSOC);


$sql_r = "SELECT * FROM respostas WHERE pergunta_id = :pergunta_id";
$stmt_r = $conn->prepare($sql_r);
$stmt_r->execute([':pergunta_id' => $pergunta_id]);
$respostas = $stmt_r->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Respostas</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .correta { color: #28a745; font-weight: bold; }
        .errada { color: #dc3545; }
        .card-resposta { background: white; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; text-align: left; position: relative; }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: auto;">
        <h1>Respostas da Pergunta</h1>
        <p style="background: #eee; padding: 15px; border-radius: 5px;">
            <strong>Pergunta:</strong> <?php echo htmlspecialchars($pergunta['texto_pergunta']); ?>
        </p>

        <a href="perguntas.php?tema_id=<?php echo $pergunta['tema_id']; ?>">⬅ Voltar para Perguntas</a> | 
        <a href="form_resposta.php?pergunta_id=<?php echo $pergunta_id; ?>" class="btn" style="background: #28a745; color: white;">➕ Adicionar Resposta</a>

        <div style="margin-top: 20px;">
            <?php foreach ($respostas as $r): ?>
                <div class="card-resposta">
                    <span><?php echo htmlspecialchars($r['texto_resposta']); ?></span>
                    <br>
                    <small class="<?php echo $r['correta'] ? 'correta' : 'errada'; ?>">
                        <?php echo $r['correta'] ? '✔ Correta' : '✖ Incorreta'; ?>
                    </small>
                    <div style="margin-top: 10px;">
                        <a href="excluir_resposta.php?id=<?php echo $r['id']; ?>&pergunta_id=<?php echo $pergunta_id; ?>" 
                           style="color: red; font-size: 12px;" 
                           onclick="return confirm('Excluir esta resposta?')">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (count($respostas) == 0): ?>
                <p>Nenhuma resposta cadastrada. (Mínimo recomendado: 4)</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>