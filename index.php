<?php include 'includes/header.php'; ?> 
<?php include 'includes/menu.php'; ?>

<?php
include 'config.php';

if ($conn) {
    echo "<p>✅ Conexão com banco funcionando!</p>";
}

$resultado = $conn->query("SELECT * FROM modelosTratores");

while($linha = $resultado->fetch_assoc()) {
    echo "<p>🚜 Modelo: " . $linha['modelo'] . "</p>";
}
?>

<?php 

$revisoes = [
    [
        "horas" => "250 Horas",
        "imagem" => "imgs/revisao250h.png",
        "itens" => [
            "Troca do óleo do motor",
            "Troca do filtro de óleo",
            "Inspeção geral"
        ]
    ],

    [
        "horas" => "500 Horas",
        "imagem" => "imgs/revisao500h.png",
        "itens" => [
            "Filtro de combustível",
            "Filtro hidráulico",
            "Óleo da transmissão"
        ]
    ],

    [
        "horas" => "1000 Horas",
        "imagem" => "imgs/revisao1000h.png",
        "itens" => [
            "Regulagem de válvulas",
            "Troca de correias",
            "Inspeção completa"
        ]
    ]

];

?>

<div class="hero-intro">
    <h1>Planos de Revisão para Tratores John Deere Linha 5000</h1>

    <p>Este site apresenta informações sobre os planos de revisão
        recomendados para tratores John Deere da Linha 5000,
        auxiliando na compreensão dos intervalos de manutenção,
        itens inspecionados e benefícios das revisões periódicas.
        
    </p>    
</div>

<section class="hero">

</section>

<section class="info">

    <div class="container">
        <h2>Por que realizar as revisões?</h2>
        
        <p>
            Os planos de revisão garantem o desempenho, segurança e
            durabilidade do trator. Além disso, a realização das revisões
            dentro dos intervalos recomendados pela fabricante mantém a
            cobertura da garantia estendida.
        </p>

        <div class="alert alert-success" role="alert">

            ✅ Realizando todos os planos de revisão dentro dos prazos,
            o cliente mantém a garantia de até 3 anos da máquina.
        
        </div>

    </div>

</section>

<section class="container">

    <h2 class="titulo-cards">Plano de Revisão</h2>

    <div class="cards">

        <?php foreach($revisoes as $revisao): ?>

            <div class="card h-100">

                <img
                    src="<?= $revisao['imagem']; ?>"
                        alt="" class="zoom-img" onclick="abrirImagem(this.src)"
>

                <div class="card-content">
                    
                    <h2><?= $revisao['horas']; ?></h2>

                    <ul>

                        <?php foreach ( $revisao['itens'] as $item): ?>

                            <li> 🔧 <?= $item; ?></li>
                        
                        <?php endforeach; ?>
                        
                    </ul>
                    
                    <a href="detalhes.php?id=<?= explode(' ', $revisao['horas'])[0] ?>" class="btn">
                        Ver detalhes
                    </a>

                </div>

            </div>
        
        <?php endforeach; ?>
    
    </div>

</section>

<div id="modalImagem" class="modal-imagem">
    <span class="fechar" onclick="fecharImagem()">&times;</span>
    <img id="imagemAmpliada">
</div>

<section class="contato">

    <h2>Agende sua Revisão</h2>

    <p>
        Nossa equipe está pronta para auxiliar na manutenção preventiva
        dos tratores John Deere da Linha 5000.
    </p>

    <a
        href="https://wa.me/5561984800449?text=Olá!%0A%0AGostaria%20de%20saber%20mais%20sobre%20as%20revisões%20dos%20tratores%20John%20Deere%20da%20Linha%205000.%0A%0APoderiam%20me%20orientar?"
        target="_blank"
        class="btn-whatsapp"
        >
            📞 Solicitar Atendimento via WhatsApp
    </a>

</section>

<?php include 'includes/footer.php'; ?>