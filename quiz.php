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
       <div class="options-container">
    <?php while($resposta = $stmt_respostas->fetch(PDO::FETCH_ASSOC)): ?>
        <div>
            <input type="radio" name="resposta_id" value="<?= $resposta['id'] ?>" id="resp<?= $resposta['id'] ?>" required>
            <label for="resp<?= $resposta['id'] ?>">
                <div class="option-card">
                    <?= htmlspecialchars($resposta['texto_resposta']) ?>
                </div>
            </label>
        </div>
    <?php endwhile; ?>
</div>

<div class="progress-container">
    <?php 
        $total = count($_SESSION['perguntas_ids']);
        $atual = $_SESSION['pergunta_atual_index'];
        $porcentagem = ($atual / $total) * 100;
    ?>
    <div class="progress-bar" style="width: <?= $porcentagem ?>%"></div>
</div>
        <input type="hidden" name="tema_id" value="<?php echo $tema_id; ?>">
        <button type="submit" class="btn btn-success">Próxima Pergunta</button>
    </form>
    <script>
   
    let tempoRestante = 30; 
    const timerElement = document.createElement('div');
    timerElement.style.fontSize = '1.5rem';
    timerElement.style.fontWeight = 'bold';
    timerElement.style.color = 'var(--danger)';
    timerElement.style.marginBottom = '10px';
    document.querySelector('h1').after(timerElement);

    const intervalo = setInterval(() => {
        tempoRestante--;
        timerElement.innerText = `Tempo: ${tempoRestante}s`;

        if (tempoRestante <= 0) {
            clearInterval(intervalo);
            alert("O tempo acabou!");
            document.querySelector('form').submit(); 
        }
    }, 1000);

    
    const cards = document.querySelectorAll('.option-card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            
            cards.forEach(c => c.style.boxShadow = 'none');
            card.style.boxShadow = '0 0 10px var(--primary)';
        });
    });
</script>
</body>
</html>