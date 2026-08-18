<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<?php
include 'config.php';
?>

<?php

$revisoes = [
    [
        "horas" => "250 horas",
        "imagem" => "imgs/revisao250h.jpg",
        "itens" => [
            "Troca de óleo do motor",
            "Troca do filtro de óleo",
            "Verificação do sistema de arrefecimento",
            "Lubrificação dos pontos de graxa"
        ]
    ],

    [
        "horas" => "500 horas",
        "imagem" => "imgs/revisao500h.jpg",
        "itens" => [
            "Troca de óleo do motor",
            "Troca do filtro de óleo",
            "Verificação do sistema de arrefecimento",
            "Lubrificação dos pontos de graxa",
            "Troca do filtro de combustível"
        ]
    ],

    [
        "horas" => "1000 horas",
        "imagem" => "imgs/revisao1000h.jpg",
        "itens" => [
            "Regulagem de válvulas",
            "Troca de correias",
            "Inspeção do sistema hidráulico",
            "Inspeção completa do trator"
        ]
    ]
];

function tempoEstimadoRevisao($itens){
    return count($itens) * 30;
}

$busca = $_GET['busca'] ?? '';

$resultadoBanco = $conn->query("
    SELECT
        id_revisao,
        horas
    FROM revisoes
");

?>

<section class="container">

    <h1>Plano de Revisões</h1>
    
    <form method="GET" class="mb-4">

    <input
        type="text"
        name="busca"
        placeholder="Digite 250, 500 ou 1000"
        class="form-control"
        value="<?= $busca ?>"
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

        <?php foreach ($revisoes as $revisao): ?>

            <?php
                if ($busca != '' && strpos($revisao['horas'], $busca) === false) {
                continue;
                }
            ?>

            <tr>
                <td><?= $revisao['horas'] ?></td>
                <td><?= count($revisao['itens']) ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>


<h2>Revisões carregadas do Banco</h2>

<ul>

<?php while($linha = $resultadoBanco->fetch_assoc()): ?>

    <li>
        Revisão <?= $linha['horas'] ?> horas
    </li>

<?php endwhile; ?>

</ul>

<br>

<div class="cards">

        <?php foreach ($revisoes as $revisao): ?>

        <?php
            if ($busca != '' && strpos($revisao['horas'], $busca) === false) {
            continue;
            }
        ?>

            <div class="card">

                <img src="<?= $revisao['imagem'] ?>" alt="">

                <div class="card-content">

                    <h2><?= $revisao['horas'] ?></h2>

                    <ul>

                        <?php foreach ($revisao['itens'] as $item): ?>

                            <li>🔧 <?= $item ?></li>

                        <?php endforeach; ?>

                    </ul>

                    <p>
                        ⏱ Tempo estimado: <?= tempoEstimadoRevisao($revisao['itens']) ?> minutos
                    </p>

                    <a href="detalhes.php?id=<?= explode(' ', $revisao['horas'])[0] ?>" class="btn">
                        Ver Detalhes
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>

<?php include 'includes/footer.php'; ?>