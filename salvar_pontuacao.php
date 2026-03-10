<?php
include 'config/connect.php';

if (isset($_POST['nome_usuario'])) {
    $nome = htmlspecialchars($_POST['nome_usuario']);
    $pontos = (int)$_POST['pontuacao'];
    
   
    if (isset($_SESSION['is_desafio']) && $_SESSION['is_desafio'] == true) {
        $sql = "INSERT INTO ranking_diario (nome_usuario, pontuacao) VALUES (:nome, :pontos)";
        
        
        $tempo_ate_amanha = strtotime('tomorrow') - time();
        setcookie('desafio_concluido', '1', time() + $tempo_ate_amanha, "/");
        
        unset($_SESSION['is_desafio']);
        $proxima_pagina = "ranking_diario.php";
    } else {
        $sql = "INSERT INTO ranking (nome_usuario, pontuacao) VALUES (:nome, :pontos)";
        $proxima_pagina = "ranking.php";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute([':nome' => $nome, ':pontos' => $pontos]);

    header("Location: $proxima_pagina");
    exit;
}
?>