<?php

include 'config.php';
include 'includes/header.php';
include 'includes/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_GET['id'];
    $novoModelo = trim($_POST['modelo']);

    if ($novoModelo !== '') {

        $sqlUpdate = "UPDATE modelostratores
                      SET modelo = ?
                      WHERE id_modelo = ?";

        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $novoModelo, $id);
        $stmtUpdate->execute();

        header("Location: modelos.php");
        exit;
    }
}

$id = $_GET['id'];

$sql = "SELECT id_modelo, modelo
        FROM modelostratores
        WHERE id_modelo = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$modelo = $resultado->fetch_assoc();

?>

<div class="container">

    <h2>Editar Modelo</h2>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Modelo
            </label>

            <input
                type="text"
                name="modelo"
                class="form-control"
                value="<?= $modelo['modelo']; ?>"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-warning"
        >
            Salvar Alterações
        </button>

    </form>

</div>

<?php include 'includes/footer.php'; ?>