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
            buttoIncluir.addEventListener('click', () => {
                this.getTelaInclusaoCidade("../view/ClassViewManutencaoCidade.php")
            })
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