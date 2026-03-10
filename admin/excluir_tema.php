<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        
        $sql = "DELETE FROM temas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        header('Location: index.php?msg=Tema excluído com sucesso');
        exit;
        
    } catch(PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }
}
?>