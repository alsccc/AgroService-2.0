<?php

include 'config.php';
include 'includes/header.php';
include 'includes/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_item = trim($_POST['nome_item']);
    $id_revisao = (int) $_POST['id_revisao'];

    if ($nome_item !== '' && $id_revisao > 0) {

        // 1. Cadastra o item
        $stmt = $conn->prepare(
            "INSERT INTO itens (nome_item) VALUES (?)"
        );

        $stmt->bind_param("s", $nome_item);
        $stmt->execute();

        // Pega o ID do item que acabou de ser criado
        $id_item = $conn->insert_id;

        // 2. Vincula o item à revisão escolhida
        $stmtVinculo = $conn->prepare(
            "INSERT INTO revisaoItens (id_revisao, id_item)
             VALUES (?, ?)"
        );

        $stmtVinculo->bind_param(
            "ii",
            $id_revisao,
            $id_item
        );

        $stmtVinculo->execute();

        header("Location: itens.php");
        exit;
    }
}

$sql = "SELECT id_item, nome_item
        FROM itens
        ORDER BY nome_item";

$resultado = $conn->query($sql);

$sqlRevisoes = "SELECT
                    r.id_revisao,
                    r.horas,
                    m.modelo
                FROM revisoes r
                INNER JOIN modelostratores m
                    ON r.id_modelo = m.id_modelo
                ORDER BY m.modelo, r.horas";

$resultadoRevisoes = $conn->query($sqlRevisoes);

?>

<div class="container">

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'item_em_uso'): ?>

        <div class="alert alert-danger">
            Este item não pode ser excluído porque está sendo usado em uma revisão.
        </div>

    <?php endif; ?>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'excluido'): ?>

        <div class="alert alert-success">
            Item excluído com sucesso.
        </div>

    <?php endif; ?>

    <h2>Gerenciar Itens</h2>

    <h4 class="mt-4">Cadastrar Item</h4>

    <form method="POST" class="mb-4">

        <div class="mb-3">

            <label
                for="nome_item"
                class="form-label"
            >
                Nome do Item
            </label>

            <input
                type="text"
                name="nome_item"
                id="nome_item"
                class="form-control"
                placeholder="Ex: Filtro de combustível"
                required
            >

        </div>

        <div class="mb-3">

            <label
                for="id_revisao"
                class="form-label"
            >
                Vincular à Revisão
            </label>

            <select
                name="id_revisao"
                id="id_revisao"
                class="form-select"
                required
            >

                <option value="">
                    Selecione uma revisão
                </option>

                <?php while ($revisao = $resultadoRevisoes->fetch_assoc()): ?>

                    <option value="<?= $revisao['id_revisao']; ?>">

                        <?= $revisao['modelo']; ?>
                        -
                        <?= $revisao['horas']; ?>h

                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <button
            type="submit"
            class="btn btn-success"
        >
            Cadastrar Item
        </button>

    </form>

    <table class="table table-dark table-striped">

        <thead>

            <tr>

                <th>ID</th>
                <th>Item</th>
                <th>Ações</th>

            </tr>

        </thead>

        <tbody>

            <?php while ($linha = $resultado->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= $linha['id_item']; ?>
                    </td>

                    <td>
                        <?= $linha['nome_item']; ?>
                    </td>

                    <td>

                        <a
                            href="editar_item.php?id=<?= $linha['id_item']; ?>"
                            class="btn btn-warning btn-sm"
                        >
                            Editar
                        </a>

                        <a
                            href="excluir_item.php?id=<?= $linha['id_item']; ?>"
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