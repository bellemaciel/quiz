<?php
include '../config/connect.php';

if (!isset($_SESSION['admin_id'])) { exit; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $pergunta_id = (int)$_POST['pergunta_id'];
    $texto = htmlspecialchars($_POST['texto_resposta']);
    $correta = isset($_POST['correta']) ? 1 : 0;

    try {
        
        if ($correta == 1) {
            $sql_reset = "UPDATE respostas SET correta = 0 WHERE pergunta_id = :pergunta_id";
            $stmt_reset = $conn->prepare($sql_reset);
            $stmt_reset->execute([':pergunta_id' => $pergunta_id]);
        }

        if ($id > 0) {
            $sql = "UPDATE respostas SET texto_resposta = :texto, correta = :correta WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':texto' => $texto, ':correta' => $correta, ':id' => $id]);
        } else {
            $sql = "INSERT INTO respostas (pergunta_id, texto_resposta, correta) VALUES (:pergunta_id, :texto, :correta)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':pergunta_id' => $pergunta_id, ':texto' => $texto, ':correta' => $correta]);
        }

        header("Location: respostas.php?pergunta_id=" . $pergunta_id);
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}