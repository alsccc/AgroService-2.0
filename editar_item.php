<?php

include 'config.php';
include 'includes/header.php';
include 'includes/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_GET['id'];
    $nome_item = trim($_POST['nome_item']);

    if ($nome_item !== '') {

        $sqlUpdate = "UPDATE itens
                      SET nome_item = ?
                      WHERE id_item = ?";

        $stmtUpdate = $conn->prepare($sqlUpdate);

        $stmtUpdate->bind_param(
            "si",
            $nome_item,
            $id
        );

        $stmtUpdate->execute();

        header("Location: itens.php");
        exit;
    }
}

$id = $_GET['id'];

$sql = "SELECT id_item, nome_item
        FROM itens
        WHERE id_item = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$item = $resultado->fetch_assoc();

?>

<div class="container">

    <h2>Editar Item</h2>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">
                Nome do Item
            </label>

            <input
                type="text"
                name="nome_item"
                class="form-control"
                value="<?= $item['nome_item']; ?>"
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