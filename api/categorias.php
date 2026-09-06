<?php

header('Content-Type: application/json; charset=utf-8');

require_once "../config.php";

$sql = "SELECT 
            id_modelo AS id,
            modelo AS nome
        FROM modelostratores
        ORDER BY modelo";

$resultado = mysqli_query($conn, $sql);

$categorias = array();

while ($linha = mysqli_fetch_assoc($resultado)) {

    $categorias[] = $linha;

}

echo json_encode($categorias, JSON_UNESCAPED_UNICODE);

?>