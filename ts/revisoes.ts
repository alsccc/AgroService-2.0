interface Categoria {
    id: string;
    nome: string;
}

interface Revisao {
    id_revisao: string;
    modelo: string;
    horas: string;
    descricao: string;
    total_itens: string;
}

async function buscarCategorias(): Promise<Categoria[]> {

    try {

        const resposta = await fetch("api/categorias.php");

        if (!resposta.ok) {
            throw new Error("Falha ao buscar categorias");
        }

        const dados: Categoria[] = await resposta.json();

        return dados;

    } catch (erro) {

        console.error("Erro ao buscar categorias:", erro);

        return [];

    }
}

function renderizarCategorias(categorias: Categoria[]): void {

    const container = document.getElementById("categorias-nav-links");

    if (container === null) {
        return;
    }

    if (categorias.length === 0) {
        container.innerHTML = "<p>Nenhum modelo encontrado.</p>";
        return;
    }

    const linksHtml = categorias.map((categoria) => {

        return `
            <a href="revisoes.php?modelo=${categoria.id}"
               class="btn btn-success me-2 mb-2">
                ${categoria.nome}
            </a>
        `;

    });

    container.innerHTML = linksHtml.join("");
}

async function carregarRevisoes(): Promise<void> {

    try {

        const resposta = await fetch("api/revisoes.php");

        if (!resposta.ok) {
            throw new Error("Falha ao buscar revisões");
        }

        const revisoes: Revisao[] = await resposta.json();

        // FILTER
        // Seleciona revisões com 4 ou mais itens
        const revisoesComMuitosItens = revisoes.filter((revisao) => {
            return Number(revisao.total_itens) >= 4;
        });

        console.log(
            "Revisões com 4 ou mais itens:",
            revisoesComMuitosItens
        );

        // RANKING
        // Organiza da revisão com mais itens para a com menos itens
        const rankingRevisoes = [...revisoes].sort((a, b) => {
            return Number(b.total_itens) - Number(a.total_itens);
        });

        console.log(
            "Ranking de revisões por quantidade de itens:",
            rankingRevisoes
        );

        console.log("Todas as revisões:", revisoes);

    } catch (erro) {

        console.error("Erro ao carregar revisões:", erro);

    }
}

carregarRevisoes();

async function testarCategorias(): Promise<void> {

    const categorias = await buscarCategorias();

    renderizarCategorias(categorias);

}

testarCategorias();