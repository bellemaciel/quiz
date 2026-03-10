<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$id = 0;
$tema_id = (int)$_GET['tema_id']; 
$texto_pergunta = '';
$titulo_pagina = "Nova Pergunta";


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM perguntas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($p) {
        $texto_pergunta = $p['texto_pergunta'];
        $titulo_pagina = "Editar Pergunta";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $titulo_pagina; ?></h1>
        
        <form action="salvar_pergunta.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="tema_id" value="<?php echo $tema_id; ?>">

            <div style="margin-bottom: 15px;">
                <label>Texto da Pergunta:</label><br>
                <textarea name="texto_pergunta" required style="width: 100%; height: 100px; padding: 10px;"><?php echo htmlspecialchars($texto_pergunta); ?></textarea>
            </div>

            <button type="submit" class="btn" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
                Salvar Pergunta
            </button>
            <a href="perguntas.php?tema_id=<?php echo $tema_id; ?>" style="margin-left: 10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>