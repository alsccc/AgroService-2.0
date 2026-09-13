<?php

include 'config.php';
include 'includes/header.php';
include 'includes/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $modelo = trim($_POST['modelo']);

    if ($modelo !== '') {

        $stmt = $conn->prepare(
            "INSERT INTO modelostratores (modelo) VALUES (?)"
        );

        $stmt->bind_param("s", $modelo);
        $stmt->execute();

        header("Location: modelos.php");
        exit;
    }
}

$sql = "SELECT id_modelo, modelo FROM modelostratores ORDER BY modelo";

$resultado = $conn->query($sql);

?>

<div class="container">

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'modelo_em_uso'): ?>

        <div class="alert alert-danger">
            Este modelo não pode ser excluído porque possui revisões cadastradas.
        </div>

    <?php endif; ?>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'excluido'): ?>

        <div class="alert alert-success">
            Modelo excluído com sucesso.
        </div>

    <?php endif; ?>

    <h2>Modelos de Tratores</h2>

    <form method="POST" class="mb-4">

        <div class="mb-3">
            <label for="modelo" class="form-label">
                Novo modelo
            </label>

            <input
                type="text"
                name="modelo"
                id="modelo"
                class="form-control"
                placeholder="Ex: 5070E"
                required
            >
        </div>

        <button type="submit" class="btn btn-success">
            Cadastrar Modelo
        </button>

    </form>

    <table class="table table-dark table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

            <?php while ($linha = $resultado->fetch_assoc()): ?>

                <tr>
                    <td><?= $linha['id_modelo']; ?></td>
                    <td><?= $linha['modelo']; ?></td>

                    <td>
                        <a
                            href="editar_modelo.php?id=<?= $linha['id_modelo']; ?>"
                            class="btn btn-warning btn-sm"
                        >
                            Editar
                        </a>
                        <a
                            href="excluir_modelo.php?id=<?= $linha['id_modelo']; ?>"
                            class="btn btn-danger btn-sm"
                        >
                            Excluir
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include 'includes/footer.php'; ?>