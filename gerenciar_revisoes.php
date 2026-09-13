    <?php

    include 'config.php';
    include 'includes/header.php';
    include 'includes/menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id_modelo = (int) $_POST['id_modelo'];
        $horas = (int) $_POST['horas'];
        $descricao = trim($_POST['descricao']);

        if ($id_modelo > 0 && $horas > 0 && $descricao !== '') {

            $stmt = $conn->prepare(
                "INSERT INTO revisoes (id_modelo, horas, descricao)
                VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "iis",
                $id_modelo,
                $horas,
                $descricao
            );

            $stmt->execute();

            header("Location: gerenciar_revisoes.php");
            exit;
        }
    }

    $sql = "SELECT
                r.id_revisao,
                m.modelo,
                r.horas,
                r.descricao
            FROM revisoes r
            INNER JOIN modelostratores m
                ON r.id_modelo = m.id_modelo
            ORDER BY r.horas";

    $resultado = $conn->query($sql);

    ?>

    <div class="container">

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'revisao_em_uso'): ?>

            <div class="alert alert-danger">
                Esta revisão não pode ser excluída porque possui itens vinculados.
            </div>

        <?php endif; ?>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'excluido'): ?>

            <div class="alert alert-success">
                Revisão excluída com sucesso.
            </div>

        <?php endif; ?>

        <h2>Gerenciar Revisões</h2>

        <h4 class="mt-4">Cadastrar Revisão</h4>

    <form method="POST" class="mb-4">

        <div class="mb-3">
            <label class="form-label">Modelo</label>

            <select name="id_modelo" class="form-select" required>
                <option value="">Selecione o modelo</option>

                <?php
                $modelos = $conn->query(
                    "SELECT id_modelo, modelo
                    FROM modelostratores
                    ORDER BY modelo"
                );

                while ($modelo = $modelos->fetch_assoc()):
                ?>

                    <option value="<?= $modelo['id_modelo']; ?>">
                        <?= $modelo['modelo']; ?>
                    </option>

                <?php endwhile; ?>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Horas</label>
            <input
                type="number"
                name="horas"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input
                type="text"
                name="descricao"
                class="form-control"
                required
            >
        </div>

        <button type="submit" class="btn btn-success">
            Cadastrar Revisão
        </button>

    </form>

        <table class="table table-dark table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Horas</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($linha = $resultado->fetch_assoc()): ?>

                    <tr>
                        <td><?= $linha['id_revisao']; ?></td>
                        <td><?= $linha['modelo']; ?></td>
                        <td><?= $linha['horas']; ?>h</td>
                        <td><?= $linha['descricao']; ?></td>
                        <td>
                            <a
                                href="editar_revisao.php?id=<?= $linha['id_revisao']; ?>"
                                class="btn btn-warning btn-sm"
                            >
                                Editar
                            </a>
                            <a
                                href="excluir_revisao.php?id=<?= $linha['id_revisao']; ?>"
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