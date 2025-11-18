<?php
include 'config/connect.php'; 


$sql = "SELECT id, nome FROM temas";
$stmt = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quiz Interativo - Início</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bem-vindo ao QZPLAY!</h1>
    <h2>Escolha um tema para começar :</h2>
    
    <ul>
        <?php
        if ($stmt->rowCount() > 0) {
            
      
            while($tema = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li><a href="quiz.php?tema_id=' . $tema['id'] . '&q=0">' . $tema['nome'] . '</a></li>';
            }
        } else {
            echo '<li>Nenhum tema disponível no momento.</li>';
        }
        ?>
    </ul>
    
    <a href="ranking.php">Ver Ranking Geral</a>
</body>
</html>