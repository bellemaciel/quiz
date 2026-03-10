<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$id = 0;
$pergunta_id = (int)$_GET['pergunta_id'];
$texto_resposta = '';
$correta = 0;


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM respostas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $texto_resposta = $r['texto_resposta'];
        $correta = $r['correta'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Salvar Resposta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $id > 0 ? "Editar Resposta" : "Nova Resposta"; ?></h1>
        
        <form action="salvar_resposta.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="pergunta_id" value="<?php echo $pergunta_id; ?>">

            <div style="margin-bottom: 15px; text-align: left;">
                <label>Texto da Alternativa:</label><br>
                <input type="text" name="texto_resposta" value="<?php echo htmlspecialchars($texto_resposta); ?>" required style="width: 100%; padding: 10px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px; text-align: left;">
                <label>
                    <input type="checkbox" name="correta" value="1" <?php echo $correta ? 'checked' : ''; ?>>
                    Esta é a resposta correta?
                </label>
            </div>

            <button type="submit" class="btn" style="background: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer;">
                Salvar Alternativa
            </button>
            <a href="respostas.php?pergunta_id=<?php echo $pergunta_id; ?>" style="margin-left: 10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>