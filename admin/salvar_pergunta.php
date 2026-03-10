<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { exit; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $tema_id = (int)$_POST['tema_id'];
    $texto = htmlspecialchars($_POST['texto_pergunta']);

    try {
        if ($id > 0) {
            $sql = "UPDATE perguntas SET texto_pergunta = :texto WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':texto' => $texto, ':id' => $id]);
        } else {
            $sql = "INSERT INTO perguntas (tema_id, texto_pergunta) VALUES (:tema_id, :texto)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':tema_id' => $tema_id, ':texto' => $texto]);
        }

        header("Location: perguntas.php?tema_id=" . $tema_id);
        exit;

    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
}