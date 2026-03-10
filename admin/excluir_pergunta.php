<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { exit; }

if (isset($_GET['id']) && isset($_GET['tema_id'])) {
    $id = (int)$_GET['id'];
    $tema_id = (int)$_GET['tema_id'];

    $sql = "DELETE FROM perguntas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: perguntas.php?tema_id=" . $tema_id);
    exit;
}