<?php
include 'config/connect.php';


$sql = "SELECT nome_usuario, pontuacao FROM ranking ORDER BY pontuacao DESC LIMIT 10";
$stmt = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Ranking</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        ol { width: 300px; margin: auto; }
        li { display: flex; justify-content: space-between; padding: 5px; }
        li span:first-child { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Ranking Geral (Top 10)</h1>
    
    <ol>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li>';
                echo '<span>' . htmlspecialchars($linha['nome_usuario']) . '</span>';
                echo '<span>' . $linha['pontuacao'] . ' Pontos</span>';
                echo '</li>';
            }
        } else {
            echo '<li>Nenhuma pontuação registrada ainda.</li>';
        }
        ?>
    </ol>
    
    <a href="index.php">Jogar Novamente</a>
</body>
</html>