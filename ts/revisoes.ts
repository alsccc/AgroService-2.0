async function carregarRevisoes() {

    try {

        const resposta = await fetch("api/revisoes.php"); // requisição da API
        
        const revisoes = await resposta.json(); 

        console.log(revisoes);

    } catch (erro) { // se der errado, mensagem de retorno

        console.error("Erro ao carregar revisões:", erro);

    }

}

carregarRevisoes(); // chamada da função

export {};