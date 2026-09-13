<?php

include 'config.php';

$id = (int) $_GET['id'];

// Verifica se o item está sendo usado em alguma revisão
$sqlVerifica = "SELECT COUNT(*) AS total
                FROM revisaoItens
                WHERE id_item = ?";

$stmtVerifica = $conn->prepare($sqlVerifica);
$stmtVerifica->bind_param("i", $id);
$stmtVerifica->execute();

$resultado = $stmtVerifica->get_result();
$dados = $resultado->fetch_assoc();

if ($dados['total'] > 0) {

    header("Location: itens.php?erro=item_em_uso");
    exit;

}

// Se não estiver em uso, pode excluir
$sqlDelete = "DELETE FROM itens
              WHERE id_item = ?";

$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();

header("Location: itens.php?sucesso=excluido");
exit;

?>