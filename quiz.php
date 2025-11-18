<?php
include 'config/connect.php'; 

$tema_id = (int)$_GET['tema_id'];


if (isset($_GET['q']) && $_GET['q'] == 0) {
    $_SESSION['score'] = 0; 
    $_SESSION['perguntas_ids'] = [];
    

    $sql_perguntas = "SELECT id FROM perguntas WHERE tema_id = :tema_id ORDER BY RAND()";
    $stmt = $conn->prepare($sql_perguntas);
    

    $stmt->execute([':tema_id' => $tema_id]);
    
  
    while ($pergunta = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['perguntas_ids'][] = $pergunta['id'];
    }
    
    $_SESSION['pergunta_atual_index'] = 0; 
}


if ($_SESSION['pergunta_atual_index'] >= count($_SESSION['perguntas_ids'])) {
    
    header('Location: resultado.php');
    exit;
}


$pergunta_id_atual = (int)$_SESSION['perguntas_ids'][$_SESSION['pergunta_atual_index']];


$sql_pergunta = "SELECT texto_pergunta FROM perguntas WHERE id = :id";
$stmt_pergunta = $conn->prepare($sql_pergunta);
$stmt_pergunta->execute([':id' => $pergunta_id_atual]);
$pergunta = $stmt_pergunta->fetch(PDO::FETCH_ASSOC);


$sql_respostas = "SELECT id, texto_resposta FROM respostas WHERE pergunta_id = :id";
$stmt_respostas = $conn->prepare($sql_respostas);
$stmt_respostas->execute([':id' => $pergunta_id_atual]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Jogando</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($pergunta['texto_pergunta']); ?> </h1>
    
    <form action="processar_resposta.php" method="POST">
        <?php
        
        while($resposta = $stmt_respostas->fetch(PDO::FETCH_ASSOC)) {
            echo '<div>';
            echo '<input type="radio" name="resposta_id" value="' . $resposta['id'] . '" id="resp' . $resposta['id'] . '" required>';
            
            echo '<label for="resp' . $resposta['id'] . '">' . htmlspecialchars($resposta['texto_resposta']) . '</label>';
            echo '</div>';
        }
        ?>
        <input type="hidden" name="tema_id" value="<?php echo $tema_id; ?>">
        <button type="submit">Próxima Pergunta</button>
    </form>
</body>
</html>