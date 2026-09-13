<?php include 'includes/header.php'; ?> 
<?php include 'includes/menu.php'; ?>

<?php
include 'config.php';

function tempoEstimadoRevisao(array $itens) {
    return count($itens) * 30;
}

$busca = $_GET['busca'] ?? '';
$modelo = $_GET['modelo'] ?? '';

$sqlTabela = "
    SELECT
        r.id_revisao,
        r.horas,
        r.id_modelo,
        COUNT(ri.id_item) AS quantidade_itens
    FROM revisoes r
    LEFT JOIN revisaoItens ri
        ON r.id_revisao = ri.id_revisao
";

if ($modelo != '') {
    $sqlTabela .= " WHERE r.id_modelo = " . intval($modelo);
}

$sqlTabela .= "
    GROUP BY r.id_revisao, r.horas, r.id_modelo
    ORDER BY r.horas
";

$resultadoTabela = $conn->query($sqlTabela);

$sqlCards = "
    SELECT
        r.id_revisao,
        r.horas,
        r.descricao,
        r.id_modelo,
        i.id_item,
        i.nome_item
    FROM revisoes r
    LEFT JOIN revisaoItens ri
        ON r.id_revisao = ri.id_revisao
    LEFT JOIN itens i
        ON ri.id_item = i.id_item
";

if ($modelo != '') {
    $sqlCards .= " WHERE r.id_modelo = " . intval($modelo);
}

$sqlCards .= "
    ORDER BY r.horas, i.id_item
";

$resultadoCards = $conn->query($sqlCards);

$revisoes = [];

while ($linha = $resultadoCards->fetch_assoc()) {

    $idRevisao = $linha['id_revisao'];

    if (!isset($revisoes[$idRevisao])) {

        $revisoes[$idRevisao] = [
            "id_revisao" => $linha['id_revisao'],
            "horas" => $linha['horas'],
            "descricao" => $linha['descricao'],
            "imagem" => "imgs/revisao" . $linha['horas'] . "h.png",
            "itens" => []
        ];
    }

    if ($linha['nome_item'] != null) {
        $revisoes[$idRevisao]['itens'][] = $linha['nome_item'];
    }
}

$revisoes = array_values($revisoes);

// Indicadores da dashboard
$totalRevisoes = count($revisoes);

$totalItensDashboard = 0;
$maiorRevisao = 0;

foreach ($revisoes as $revisao) {

    $totalItensDashboard += count($revisao['itens']);

    if ($revisao['horas'] > $maiorRevisao) {
        $maiorRevisao = $revisao['horas'];
    }
}
?>

<section class="container">

    <h1>Plano de Revisões</h1>
    <div class="row mb-4">

    <div class="col-md-4 mb-3">
        <div class="card card-indicador text-center p-3">

            <h3>
                <?= $totalRevisoes ?>
            </h3>

            <p class="mb-0">
                Revisões disponíveis
            </p>

        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-indicador text-center p-3">

            <h3>
                <?= $totalItensDashboard ?>
            </h3>

            <p class="mb-0">
                Itens de manutenção
            </p>

        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-indicador text-center p-3">

            <h3>
                <?= $maiorRevisao ?>h
            </h3>

            <p class="mb-0">
                Maior revisão
            </p>

        </div>
    </div>

</div>

    <form method="GET" class="mb-4">

        <?php if ($modelo != ''): ?>

            <input
                type="hidden"
                name="modelo"
                value="<?= htmlspecialchars($modelo) ?>"
            >

        <?php endif; ?>

        <input
            type="text"
            name="busca"
            placeholder="Digite 250, 500 ou 1000"
            class="form-control"
            value="<?= htmlspecialchars($busca) ?>"
        >

        <br>

        <button type="submit" class="btn btn-success">
            Pesquisar
        </button>

    </form>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>Revisão</th>
                <th>Quantidade de Itens</th>
            </tr>

        </thead>

        <tbody>

            <?php while ($linha = $resultadoTabela->fetch_assoc()): ?>

                <?php

                if (
                    $busca != '' &&
                    strpos((string)$linha['horas'], $busca) === false
                ) {
                    continue;
                }

                ?>

                <tr>

                    <td>
                        <?= $linha['horas'] ?> horas
                    </td>

                    <td>
                        <?= $linha['quantidade_itens'] ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

    <h2>Revisões carregadas do Banco</h2>

    <ul>

        <?php foreach ($revisoes as $revisao): ?>

            <?php

            if (
                $busca != '' &&
                strpos((string)$revisao['horas'], $busca) === false
            ) {
                continue;
            }

            ?>

            <li>
                Revisão <?= $revisao['horas'] ?> horas
            </li>

        <?php endforeach; ?>

    </ul>

    <br>

    <div class="cards">

        <?php $encontrouRevisao = false; ?>

        <?php foreach ($revisoes as $revisao): ?>

            <?php

            if (
                $busca != '' &&
                strpos((string)$revisao['horas'], $busca) === false
            ) {
                continue;
            }

            $encontrouRevisao = true;

            ?>

            <div class="card">

                <img
                    src="<?= $revisao['imagem'] ?>"
                    alt="Revisão <?= $revisao['horas'] ?> horas"
                    class="zoom-img"
                    onclick="abrirImagem(this.src)"
                >

                <div class="card-content">

                    <h2>
                        <?= $revisao['horas'] ?> horas
                    </h2>

                    <ul>

                        <?php foreach ($revisao['itens'] as $item): ?>

                            <li>
                                🔧 <?= htmlspecialchars($item) ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                    <p>
                        ⏱ Tempo estimado:
                        <?= tempoEstimadoRevisao($revisao['itens']) ?>
                        minutos
                    </p>

                    <a
                        href="detalhes.php?id=<?= $revisao['horas'] ?>"
                        class="btn"
                    >
                        Ver Detalhes
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

        <?php if (!$encontrouRevisao): ?>

            <div class="alert alert-warning">
                Nenhuma revisão encontrada para este modelo.
            </div>

        <?php endif; ?>

    </div>

</section>

<section class="contato">

    <h2>Agende sua Revisão</h2>

    <p>
        Nossa equipe está pronta para auxiliar na manutenção preventiva
        dos tratores John Deere da Linha 5000.
    </p>

    <a
        href="https://wa.me/5561984800449?text=Olá!%0A%0AGostaria%20de%20saber%20mais%20sobre%20as%20revisões%20dos%20tratores%20John%20Deere%20da%20Linha%205000."
        target="_blank"
        class="btn-whatsapp"
    >
        📞 Solicitar Atendimento via WhatsApp
    </a>

</section>

<div id="modalImagem" class="modal-imagem">

    <span
        class="fechar"
        onclick="fecharImagem()"
    >
        &times;
    </span>

    <img id="imagemAmpliada">

</div>

<script>

    const revisoesJS = <?= json_encode(
        $revisoes,
        JSON_UNESCAPED_UNICODE
    ); ?>;

    console.log(revisoesJS);

    const totalItens = revisoesJS.reduce((total, revisao) => {
        return total + revisao.itens.length;
    }, 0);

    console.log(
        "Total de itens das revisões:",
        totalItens
    );

</script>

<script src="js/revisoes.js"></script>

<?php include 'includes/footer.php'; ?>