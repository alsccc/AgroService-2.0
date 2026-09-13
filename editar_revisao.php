<?php

include 'config.php';
include 'includes/header.php';
include 'includes/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_GET['id'];
    $horas = (int) $_POST['horas'];
    $descricao = trim($_POST['descricao']);

    if ($horas > 0 && $descricao !== '') {

        $sqlUpdate = "UPDATE revisoes
                      SET horas = ?, descricao = ?
                      WHERE id_revisao = ?";

        $stmtUpdate = $conn->prepare($sqlUpdate);

        $stmtUpdate->bind_param(
            "isi",
            $horas,
            $descricao,
            $id
        );

        $stmtUpdate->execute();

        header("Location: gerenciar_revisoes.php");
        exit;
    }
}

$id = $_GET['id'];

$sql = "SELECT
            id_revisao,
            id_modelo,
            horas,
            descricao
        FROM revisoes
        WHERE id_revisao = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$revisao = $resultado->fetch_assoc();

?>

<div class="container">

    <h2>Editar Revisão</h2>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Horas</label>

            <input
                type="number"
                name="horas"
                class="form-control"
                value="<?= $revisao['horas']; ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>

            <input
                type="text"
                name="descricao"
                class="form-control"
                value="<?= $revisao['descricao']; ?>"
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