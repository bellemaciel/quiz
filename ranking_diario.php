<?php
include 'config/connect.php';


$sql = "SELECT nome_usuario, pontuacao 
        FROM ranking_diario 
        WHERE data_obtida = CURRENT_DATE 
        ORDER BY pontuacao DESC 
        LIMIT 10";

$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Ranking Diário</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        
        ol { width: 100%; padding: 0; list-style: none; }
        li { 
            display: flex; 
            justify-content: space-between; 
            padding: 12px; 
            background: #f8f9fa;
            margin-bottom: 8px;
            border-radius: 8px;
            border-left: 5px solid var(--secondary);
        }
        li:nth-child(1) { border-left-color: #ffd700; background: #fffdf0; } 
        li:nth-child(2) { border-left-color: #c0c0c0; } 
        li:nth-child(3) { border-left-color: #cd7f32; } 
        
        .pontos { font-weight: bold; color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="color: var(--primary);">🔥 Ranking Diário</h1>
        <p>Os melhores jogadores de hoje, <?php echo date('d/m/Y'); ?></p>
        
        <hr style="width: 100%; border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

        <ol>
            <?php
            if ($stmt->rowCount() > 0) {
                $posicao = 1;
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li>';
                    echo '<span>' . $posicao . 'º - ' . htmlspecialchars($linha['nome_usuario']) . '</span>';
                    echo '<span class="pontos">' . $linha['pontuacao'] . ' pts</span>';
                    echo '</li>';
                    $posicao++;
                }
            } else {
                echo '<p style="color: #666;">Ainda não há pontuações para hoje. Seja o primeiro!</p>';
            }
            ?>
        </ol>
        
        <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px; width: 100%;">
            <a href="index.php" class="btn btn-primary">Voltar ao Início</a>
            <a href="ranking.php" class="btn btn-ranking">Ver Ranking Geral</a>
        </div>
    </div>

    <footer>
        <p>© 2026 - QZPLAY Quiz Interativo</p>
    </footer>
</body>
</html>