<?php

header('Content-Type: application/json');

require_once '../config.php';

$modelo = isset($_GET['modelo']) && $_GET['modelo'] !== ''
    ? (int) $_GET['modelo']
    : null;

$limite = isset($_GET['limite'])
    ? (int) $_GET['limite']
    : 10;

$pagina = isset($_GET['pagina'])
    ? (int) $_GET['pagina']
    : 1;

if ($limite < 1) {
    $limite = 10;
}

if ($pagina < 1) {
    $pagina = 1;
}

$offset = ($pagina - 1) * $limite;

$sql = "CALL buscar_revisoes(?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "iii",
    $modelo,
    $limite,
    $offset
);

$stmt->execute();

$resultado = $stmt->get_result();

$revisoes = [];

while ($linha = $resultado->fetch_assoc()) {
    $revisoes[] = $linha;
}

echo json_encode(
    $revisoes,
    JSON_UNESCAPED_UNICODE
);

$stmt->close();
$conn->close();

?>