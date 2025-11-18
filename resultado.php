<?php
include 'config/connect.php';


$pontuacao_final = 0;
if (isset($_SESSION['score'])) {
    $pontuacao_final = $_SESSION['score'];
}


unset($_SESSION['perguntas_ids']);
unset($_SESSION['pergunta_atual_index']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Resultado</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Quiz Finalizado!</h1>
    <h2>Sua pontuação final foi: <?php echo $pontuacao_final; ?></h2>
    
    <hr>
    
    <h3>Salvar no Ranking</h3>
    <form action="salvar_pontuacao.php" method="POST">
        <label for="nome">Seu nome:</label>
        <input type="text" name="nome_usuario" id="nome" required>
        <input type="hidden" name="pontuacao" value="<?php echo $pontuacao_final; ?>">
        <button type="submit">Salvar Pontuação</button>
    </form>
    
    <a href="index.php">Jogar Novamente</a>
</body>
</html>