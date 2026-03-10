<?php

include '../config/connect.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}


$sql = "SELECT * FROM temas ORDER BY id DESC";
$stmt = $conn->query($sql);
$temas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - Temas</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; }
        .btn-add { background-color: #28a745; margin-bottom: 20px; display: inline-block; }
    </style>
</head>
<body>
    <h1>Painel Administrativo - Gerenciar Temas</h1>
    
    <a href="form_tema.php" class="btn btn-add">Criar Novo Tema</a>
    <a href="../index.php">Sair do Admin</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Tema</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($temas as $tema): ?>
            <tr>
                <td><?php echo $tema['id']; ?></td>
                <td><?php echo htmlspecialchars($tema['nome']); ?></td>
                <td>
                    <a href="perguntas.php?tema_id=<?php echo $tema['id']; ?>" class="btn" style="background:#007bff">Perguntas</a>
                    
                    <a href="form_tema.php?id=<?php echo $tema['id']; ?>" class="btn btn-edit">Editar</a>
                    
                    <a href="excluir_tema.php?id=<?php echo $tema['id']; ?>" 
                       class="btn btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este tema e todas as perguntas ligadas a ele?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if (count($temas) == 0): ?>
                <tr><td colspan="3">Nenhum tema cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if(!confirm("⚠️ ATENÇÃO: Isso apagará todos os dados vinculados! Deseja continuar?")) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>