<?php
include 'config/connect.php';


if (isset($_POST['nome_usuario']) && isset($_POST['pontuacao'])) {
    
    
    $nome = $_POST['nome_usuario'];
    
    $pontuacao = (int)$_POST['pontuacao'];
    
    try {
       
        $sql = "INSERT INTO ranking (nome_usuario, pontuacao) VALUES (:nome, :pontuacao)";
        $stmt = $conn->prepare($sql);
        
        
        $stmt->execute([
            ':nome' => $nome,
            ':pontuacao' => $pontuacao
        ]);
        
        
        unset($_SESSION['score']);
        
        
        header('Location: ranking.php');
        exit;
        
    } catch(PDOException $e) {
        
        echo "Erro ao salvar pontuação: " . $e->getMessage();
    }

} else {
    
    header('Location: index.php');
    exit;
}
?>