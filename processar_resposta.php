<?php
include 'config/connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['resposta_id'])) {
    $resposta_id = (int)$_POST['resposta_id'];
    $tema_id = (int)$_POST['tema_id']; 

    
    $sql = "SELECT correta FROM respostas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $resposta_id]);
    $resposta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resposta && $resposta['correta'] == 1) {
        $_SESSION['score']++;
    }

  
    $_SESSION['pergunta_atual_index']++;

  
    if (isset($_SESSION['is_desafio']) && $_SESSION['is_desafio'] == true) {
        $proxima_pagina = "desafio.php";
    } else {
        $proxima_pagina = "quiz.php?tema_id=" . $tema_id;
    }
    
    header("Location: " . $proxima_pagina);
    exit;

} else {
    header('Location: index.php');
    exit;
}