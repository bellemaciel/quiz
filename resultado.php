<?php
include 'config/connect.php';


if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['score'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$nome_usuario = $_SESSION['usuario_nome'];
$acertos = $_SESSION['score'];
$total = isset($_SESSION['total_perguntas']) ? $_SESSION['total_perguntas'] : 0;


if (!isset($_SESSION['pontuacao_salva'])) {
    try {
        $sql = "INSERT INTO ranking (usuario_id, nome_usuario, pontuacao) VALUES (:uid, :nome, :pontos)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':uid'   => $usuario_id,
            ':nome'  => $nome_usuario,
            ':pontos' => $acertos
        ]);
        $_SESSION['pontuacao_salva'] = true; 
    } catch (PDOException $e) {
        $erro_salvamento = "Erro ao registrar pontos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Resultado Final</title>
    <link rel="stylesheet" href="css/style.css?v=7.0">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        .result-card { padding: 40px 20px; }
        .score-circle {
            width: 120px; height: 120px;
            background: var(--primary); color: white;
            border-radius: 50%; display: flex;
            align-items: center; justify-content: center;
            font-size: 2.5rem; font-weight: bold;
            margin: 20px auto; border: 8px solid var(--secondary);
        }
        .feedback-text { font-size: 1.2rem; margin-bottom: 20px; font-weight: 500; }
    </style>
</head>
<body>

    <div class="container animate-in result-card">
        <h1>Parabéns, <?= explode(' ', $nome_usuario)[0] ?>! 🥳</h1>
        <p>Você concluiu o desafio. Confira seu desempenho:</p>

        <div class="score-circle">
            <?= $acertos ?>
        </div>
        
        <div class="feedback-text">
            <?php 
            if($acertos == $total) echo "IMPRESSIONANTE! Gabaritou!";
            elseif($acertos >= $total/2) echo " Muito bem! Você conhece o assunto.";
            else echo "Bom esforço! Que tal estudar mais um pouco?";
            ?>
        </div>

        <p style="color: #636e72;">Pontuação registrada no ranking geral.</p>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="index.php" class="btn btn-primary" onclick="<?php unset($_SESSION['score'], $_SESSION['pontuacao_salva']); ?>">JOGAR NOVAMENTE</a>
            <a href="ranking.php" class="btn btn-ranking">VER RANKING GERAL</a>
        </div>
    </div>

    <script>
        
        window.onload = function() {
            var duration = 4 * 1000;
            var end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 3,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 },
                    colors: ['#6c5ce7', '#a29bfe', '#00b894']
                });
                confetti({
                    particleCount: 3,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 },
                    colors: ['#6c5ce7', '#a29bfe', '#00b894']
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        };
    </script>
</body>
</html>