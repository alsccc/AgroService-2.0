<?php

include 'config.php';

$id = (int) $_GET['id'];

// Verifica se a revisão possui itens vinculados
$sqlVerifica = "SELECT COUNT(*) AS total
                FROM revisaoItens
                WHERE id_revisao = ?";

$stmtVerifica = $conn->prepare($sqlVerifica);
$stmtVerifica->bind_param("i", $id);
$stmtVerifica->execute();

$resultado = $stmtVerifica->get_result();
$dados = $resultado->fetch_assoc();

if ($dados['total'] > 0) {

    header("Location: gerenciar_revisoes.php?erro=revisao_em_uso");
    exit;
}

// Se não possuir itens vinculados, pode excluir
$sqlDelete = "DELETE FROM revisoes
              WHERE id_revisao = ?";

$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();

header("Location: gerenciar_revisoes.php?sucesso=excluido");
exit;

?>