import { estClassViewComportamento } from '../../lib/estClassViewComportamento.js';

class classViewComportamentoCidade extends estClassViewComportamento {
    constructor() {
        super();
        this.initMensagemListener();
    }

    initMensagemListener() {
        const overlay = document.querySelector('.overlay');
        if (overlay) {
            this.setFundoTelaDisabledAny(overlay);
        }


        const buttoIncluir = document.querySelector('.estButtonIncluir');
        if (buttoIncluir) {
            buttoIncluir.addEventListener('click', async () => {
                try {
                    const caminho = "../view/ClassViewManutencaoCidade.php?telaInclusaoCidade";
                    const telaInclusao = await this.getTelaInclusao(caminho);
    
                    const divResponse = document.createElement("div");
                    divResponse.innerHTML = telaInclusao; 
                    document.body.appendChild(divResponse);
                } catch (error) {
                    console.error("Erro ao carregar tela de inclusão: ", error);
                }
            });
        }
    }


    getTelaInclusaoCidade(caminho) {
        return this.getTelaInclusao(caminho);
    }


    setFundoTelaDisabledAny(element) {
        super.setFundoTelaDisabledAny(element);
    }
    
    setFundoTelaActiveAny(element) {
        super.setFundoTelaActiveAny(element);
    }
}  
new classViewComportamentoCidade;