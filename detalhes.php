    <?php

    include 'includes/header.php';
    include 'includes/menu.php';

    $id = $_GET['id'] ?? '';

    $revisoes = [

        "250" => [
            "titulo" => "Revisão de 250 Horas",
            "imagem" => "imgs/revisao250h.png",
            "descricao" => "Primeira revisão preventiva do trator.",
            "itens" => [
                "Troca do óleo do motor",
                "Troca do filtro de óleo",
                "Inspeção geral"
            ]
        ],

        "500" => [
            "titulo" => "Revisão de 500 Horas",
            "imagem" => "imgs/revisao500h.png",
            "descricao" => "Revisão intermediária focada em filtros e transmissão.",
            "itens" => [
                "Troca do filtro de combustível",
                "Troca do filtro hidráulico",
                "Troca do óleo da transmissão",
                "Inspeção de vazamentos"
            ]
        ],

        "1000" => [
            "titulo" => "Revisão de 1000 Horas",
            "imagem" => "imgs/revisao1000h.png",
            "descricao" => "Revisão completa dos principais componentes do trator.",
            "itens" => [
                "Regulagem de válvulas",
                "Troca de correias",
                "Inspeção do sistema hidráulico",
                "Inspeção completa do trator"
            ]
        ]

    ];

    if (!isset($revisoes[$id])) {

        echo "<div class='container'>";
        echo "<h2>Revisão não encontrada.</h2>";
        echo "</div>";

        include 'includes/footer.php';
        exit;
    }

    $dados = $revisoes[$id];

    ?>

    <div class="container">

        <h1><?= $dados['titulo'] ?></h1>

        <br>

        <img
            src="<?= $dados['imagem'] ?>"
            alt="<?= $dados['titulo'] ?>"
            style="width:100%; max-width:700px; border-radius:10px;"
        >

        <br><br>

        <p><?= $dados['descricao'] ?></p>

        <br>

        <h3>Itens da revisão:</h3>

        <ul>

            <?php foreach ($dados['itens'] as $item): ?>

                <li>🔧 <?= $item ?></li>

            <?php endforeach; ?>

        </ul>

        <br>

        <div class="botoes-acoes">

    <a href="revisoes.php" class="btn">
        Voltar para Revisões
    </a>

    <a
        href="https://wa.me/5561984800449?text=Olá!%0A%0AGostaria%20de%20saber%20mais%20sobre%20<?= urlencode($dados['titulo']) ?>%20dos%20tratores%20John%20Deere%20Linha%205000."
        target="_blank"
        class="btn-whatsapp"
    >
        📞 Solicitar Atendimento
    </a>

</div>

    <?php include 'includes/footer.php'; ?>