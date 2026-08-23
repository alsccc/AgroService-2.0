<?php

header('Content-Type: application/json'); // colocar para que o contduo seja traduzio para json 

require_once '../config.php'; // recarregar o arquivo config.php

$sql = "
    SELECT
        id_revisao,
        id_modelo,
        horas,
        descricao
    FROM revisoes
";

$resultado = $conn->query($sql);

$revisoes = [];

while ($linha = $resultado->fetch_assoc()) {
    $revisoes[] = $linha;
}

echo json_encode($revisoes); // conversor //

?>