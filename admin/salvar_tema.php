<?php
include '../config/connect.php';


if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $nome = htmlspecialchars($_POST['nome']);
    
    
    $icone = !empty($_POST['icone']) ? htmlspecialchars($_POST['icone']) : '💡';

    try {
        if ($id > 0) {
            
            $sql = "UPDATE temas SET nome = :nome, icone = :icone WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nome'  => $nome,
                ':icone' => $icone,
                ':id'    => $id
            ]);
        } else {
            
            $sql = "INSERT INTO temas (nome, icone) VALUES (:nome, :icone)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nome'  => $nome,
                ':icone' => $icone
            ]);
        }

        
        header('Location: index.php?sucesso=1');
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit;
}