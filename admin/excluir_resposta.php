<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { exit; }

if (isset($_GET['id']) && isset($_GET['pergunta_id'])) {
    $id = (int)$_GET['id'];
    $pergunta_id = (int)$_GET['pergunta_id'];

    $sql = "DELETE FROM respostas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: respostas.php?pergunta_id=" . $pergunta_id);
    exit;
}