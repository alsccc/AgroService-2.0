<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<?php
include 'config.php';
?>

<?php

$revisoes = [
    [
        "horas" => "250 horas",
        "imagem" => "imgs/revisao250h.png",
        "itens" => [
            "Troca de óleo do motor",
            "Troca do filtro de óleo",
            "Verificação do sistema de arrefecimento",
            "Lubrificação dos pontos de graxa"
        ]
    ],

    [
        "horas" => "500 horas",
        "imagem" => "imgs/revisao500h.png",
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
        "imagem" => "imgs/revisao1000h.png",
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

$resultadoTabela = $conn->query("
    SELECT
        r.id_revisao,
        r.horas,
        COUNT(ri.id_item) AS quantidade_itens
    FROM revisoes r
    LEFT JOIN revisaoItens ri
        ON r.id_revisao = ri.id_revisao
    GROUP BY r.id_revisao, r.horas
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

       <?php while($linha = $resultadoTabela->fetch_assoc()): ?>

            <?php
                if ($busca != '' && strpos($linha['horas'], $busca) === false) {
                continue;
            }
        ?>

            <tr>
                <td><?= $linha['horas'] ?> horas</td>
                <td><?= $linha['quantidade_itens'] ?></td>
            </tr>

        <?php endwhile; ?>

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

                <img
                    src="<?= $revisao['imagem'] ?>"
                    alt=""
                    class="zoom-img"
                    onclick="abrirImagem(this.src)"
>

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

    <span class="fechar" onclick="fecharImagem()">
        &times;
    </span>

    <img id="imagemAmpliada">

</div>

<?php include 'includes/footer.php'; ?>