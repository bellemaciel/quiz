<?php
include 'config/connect.php';

$meu_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;


$sql = "SELECT usuario_id, nome_usuario, pontuacao FROM ranking ORDER BY pontuacao DESC LIMIT 10";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Ranking Geral</title>
    <link rel="stylesheet" href="css/style.css?v=8.0">
    <style>
        .ranking-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            width: 100%;
        }

        .ranking-item {
            display: flex;
            align-items: center;
            background: #fff;
            margin-bottom: 12px;
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #f0f2f5;
            transition: all 0.3s ease;
        }

       
        .is-me {
            border-color: var(--primary) !important;
            background-color: #f3f0ff !important;
            
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.2);
            transform: scale(1.03);
            
            z-index: 2;
        }

        .me-badge {
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
            text-transform: uppercase;
            font-weight: bold;
            vertical-align: middle;
        }

        .rank-pos {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 50%;
            margin-right: 15px;
            background: #f0f2f5;
            color: #636e72;
        }

        .rank-1 {
            background: #FFD700;
            color: #fff;
        }

        .rank-2 {
            background: #C0C0C0;
            color: #fff;
        }

        .rank-3 {
            background: #CD7F32;
            color: #fff;
        }

        .user-info {
            flex-grow: 1;
            text-align: left;
        }

        .user-name {
            font-weight: bold;
            color: var(--text);
            font-size: 1.1rem;
        }

        .user-score {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="animate-in">🏆 Ranking</h1>
        <p class="animate-in delay-1" style="color: #636e72;">Você está entre os melhores?</p>

        <div class="ranking-list">
            <?php
            if ($stmt->rowCount() > 0) {
                $pos = 1;
                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    $e_voce = ($meu_id && $linha['usuario_id'] == $meu_id);

                    $rankClass = '';
                    $icon = $pos;
                    if ($pos == 1) {
                        $rankClass = 'rank-1';
                        $icon = '🥇';
                    } elseif ($pos == 2) {
                        $rankClass = 'rank-2';
                        $icon = '🥈';
                    } elseif ($pos == 3) {
                        $rankClass = 'rank-3';
                        $icon = '🥉';
                    }

                    $delayClass = "delay-" . min($pos, 3);
            ?>

                    <div class="ranking-item animate-in <?= $delayClass ?> <?= $e_voce ? 'is-me' : '' ?>">
                        <div class="rank-pos <?= $rankClass ?>">
                            <?= $icon ?>
                        </div>
                        <div class="user-info">
                            <span class="user-name">
                                <?= htmlspecialchars($linha['nome_usuario']) ?>
                                <?php if ($e_voce): ?>
                                    <span class="me-badge">VOCÊ</span>
                                <?php endif; ?>
                            </span>
                            <span class="user-score"><?= number_format($linha['pontuacao'], 0, ',', '.') ?> Pontos</span>
                        </div>
                    </div>

            <?php
                    $pos++;
                }
            } else {
                echo '<div class="ranking-item">Ainda não há campeões. Seja o primeiro!</div>';
            }
            ?>
        </div>

        <div class="animate-in delay-3" style="margin-top: 20px; width: 100%;">
            <a href="index.php" class="btn btn-primary" style="width: 100%; display: block; text-align: center; box-sizing: border-box;">
                VOLTAR AO INÍCIO
            </a>
        </div>
        <div class="animate-in delay-3" style="margin-top: 10px; width: 100%;">
            <button onclick="window.print()" class="btn" style="background: #636e72; color: white; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; border: none; box-sizing: border-box; font-weight: bold;">
                🖨️ IMPRIMIR RANKING
            </button>
        </div>
    </div>
</body>

</html>