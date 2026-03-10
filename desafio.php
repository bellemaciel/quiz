<?php
include 'config/connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_COOKIE['desafio_concluido'])) {
    echo "<script>
            alert('Você já realizou o desafio de hoje! Volte amanhã para novas perguntas.');
            window.location.href='index.php';
          </script>";
    exit; 
}

$hoje = date('Y-m-d');


$check = $conn->prepare("SELECT id FROM perguntas WHERE data_desafio = :hoje AND tema_id = 0");
$check->execute([':hoje' => $hoje]);
$perguntas_hoje = $check->fetchAll(PDO::FETCH_COLUMN);


if (count($perguntas_hoje) < 5) {
    $sucesso_api = false;
    $url = "https://opentdb.com/api.php?amount=5&category=9&difficulty=medium&type=multiple";
    $context = stream_context_create(["http" => ["timeout" => 5]]);
    $response = @file_get_contents($url, false, $context);

    if ($response) {
        $dados = json_decode($response, true);
        if (isset($dados['response_code']) && $dados['response_code'] == 0) {
            foreach ($dados['results'] as $item) {
                $insP = $conn->prepare("INSERT INTO perguntas (texto_pergunta, data_desafio, tema_id) VALUES (:txt, :data, 0)");
                $insP->execute([
                    ':txt' => htmlspecialchars_decode($item['question'], ENT_QUOTES),
                    ':data' => $hoje
                ]);
                $p_id = $conn->lastInsertId();

                $insR = $conn->prepare("INSERT INTO respostas (pergunta_id, texto_resposta, correta) VALUES (:p_id, :txt, 1)");
                $insR->execute([':p_id' => $p_id, ':txt' => htmlspecialchars_decode($item['correct_answer'], ENT_QUOTES)]);

                foreach ($item['incorrect_answers'] as $inc) {
                    $insR = $conn->prepare("INSERT INTO respostas (pergunta_id, texto_resposta, correta) VALUES (:p_id, :txt, 0)");
                    $insR->execute([':p_id' => $p_id, ':txt' => htmlspecialchars_decode($inc, ENT_QUOTES)]);
                }
            }
            $sucesso_api = true;
        }
    }

    if (!$sucesso_api) {
        $sql_random = "UPDATE perguntas SET data_desafio = :hoje WHERE tema_id = 0 AND (data_desafio != :hoje OR data_desafio IS NULL) ORDER BY RAND() LIMIT 5";
        $stmt_random = $conn->prepare($sql_random);
        $stmt_random->execute([':hoje' => $hoje]);
    }

    $check->execute([':hoje' => $hoje]);
    $perguntas_hoje = $check->fetchAll(PDO::FETCH_COLUMN);
}


if (!isset($_SESSION['is_desafio']) || $_SESSION['is_desafio'] == false || !isset($_SESSION['perguntas_ids'])) {
    $_SESSION['score'] = 0;
    $_SESSION['pergunta_atual_index'] = 0;
    $_SESSION['is_desafio'] = true;
    $_SESSION['perguntas_ids'] = $perguntas_hoje;
}


$index_atual = isset($_SESSION['pergunta_atual_index']) ? $_SESSION['pergunta_atual_index'] : 0;
$perguntas_ids = isset($_SESSION['perguntas_ids']) ? $_SESSION['perguntas_ids'] : [];
$total_perguntas = count($perguntas_ids);


if ($total_perguntas == 0) {
    die("<div class='container'><h2>Erro ao carregar o desafio.</h2><a href='index.php'>Voltar</a></div>");
}

if ($index_atual >= $total_perguntas) {
    header("Location: resultado.php");
    exit;
}

$id_p = $perguntas_ids[$index_atual];
$stmt_p = $conn->prepare("SELECT texto_pergunta FROM perguntas WHERE id = :id");
$stmt_p->execute([':id' => $id_p]);
$pergunta = $stmt_p->fetch(PDO::FETCH_ASSOC);

$stmt_r = $conn->prepare("SELECT * FROM respostas WHERE pergunta_id = :id ORDER BY RAND()");
$stmt_r->execute([':id' => $id_p]);
$respostas = $stmt_r->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title> Desafio Diário - QZPLAY</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <small>Progresso: <?= ($index_atual + 1) ?> / <?= $total_perguntas ?></small>
            <span id="timer" style="color: var(--danger); font-weight: bold; font-size: 1.2rem;">30s</span>
        </div>

        <div class="progress-container">
            <div class="progress-bar" style="width: <?= ($index_atual / $total_perguntas) * 100 ?>%"></div>
        </div>

        <h2 style="margin: 20px 0;"><?= htmlspecialchars($pergunta['texto_pergunta']) ?></h2>

        <form action="processar_resposta.php" method="POST" id="formQuiz">
            <input type="hidden" name="tema_id" value="0">
            
            <div class="options-container">
                <?php foreach ($respostas as $r): ?>
                    <div>
                        <input type="radio" name="resposta_id" value="<?= $r['id'] ?>" id="resp<?= $r['id'] ?>" required>
                        <label for="resp<?= $r['id'] ?>">
                            <div class="option-card">
                                <?= htmlspecialchars($r['texto_resposta']) ?>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-success" id="btnProximo">Responder ➔</button>
        </form>
    </div>

    <script>
        
        let tempo = 30;
        const timerDisplay = document.getElementById('timer');
        const countdown = setInterval(() => {
            tempo--;
            timerDisplay.innerText = tempo + "s";
            if (tempo <= 5) timerDisplay.style.transform = "scale(1.2)";
            if (tempo <= 0) {
                clearInterval(countdown);
                document.getElementById('formQuiz').submit();
            }
        }, 1000);

      
        const btn = document.getElementById('btnProximo');
        const radios = document.querySelectorAll('input[name="resposta_id"]');
        btn.disabled = true;
        btn.style.opacity = "0.5";

        radios.forEach(r => {
            r.addEventListener('change', () => {
                btn.disabled = false;
                btn.style.opacity = "1";
            });
        });
    </script>
</body>
</html>