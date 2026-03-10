<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = 0;
$nome_tema = '';
$icone_tema = ''; 
$titulo_pagina = "Cadastrar Novo Tema";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $sql = "SELECT * FROM temas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $tema = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tema) {
        $nome_tema = $tema['nome'];
        $icone_tema = $tema['icone']; 
        $titulo_pagina = "Editar Tema: " . htmlspecialchars($nome_tema);
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

        <form action="salvar_tema.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div style="margin-bottom: 15px; text-align: left;">
                <label for="nome" style="font-weight: bold;">Nome do Tema:</label><br>
                <input type="text" name="nome" id="nome" 
                       value="<?php echo htmlspecialchars($nome_tema); ?>" 
                       required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px; text-align: left;">
                <label for="icone" style="font-weight: bold;">Ícone (Emoji ou Sigla):</label><br>
                <input type="text" name="icone" id="icone" 
                       value="<?php echo htmlspecialchars($icone_tema); ?>" 
                       placeholder="Ex: 🧠, 🎮 ou EN" 
                       maxlength="10"
                       style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box;">
                <p style="font-size: 0.85rem; color: #666; margin-top: 5px;">
                    💡 Dica: No Windows, use <b>Win + . (Ponto)</b> para escolher um emoji.
                </p>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <button type="submit" class="btn" style="background: #28a745; color: white; padding: 12px 25px; border: none; cursor: pointer; border-radius: 8px; font-weight: bold;">
                    Salvar Tema
                </button>
                
                <a href="index.php" style="text-decoration: none; color: #666; font-size: 0.9rem;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>