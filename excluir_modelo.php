<?php

include 'config.php';

$id = (int) $_GET['id'];

// Verifica se existem revisões vinculadas ao modelo
$sqlVerifica = "SELECT COUNT(*) AS total
                FROM revisoes
                WHERE id_modelo = ?";

$stmtVerifica = $conn->prepare($sqlVerifica);
$stmtVerifica->bind_param("i", $id);
$stmtVerifica->execute();

$resultado = $stmtVerifica->get_result();
$dados = $resultado->fetch_assoc();

if ($dados['total'] > 0) {

    header("Location: modelos.php?erro=modelo_em_uso");
    exit;
}

// Se não possuir revisões, pode excluir
$sqlDelete = "DELETE FROM modelostratores
              WHERE id_modelo = ?";

$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();

header("Location: modelos.php?sucesso=excluido");
exit;

?>