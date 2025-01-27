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
            const caminho = "../view/ClassViewManutencaoCidade.php?telaInclusaoCidade";
            buttoIncluir.addEventListener('click', async () => {
                this.doAjaxTelaInclusao(caminho);
            });
        }
    }
}  
new classViewComportamentoCidade;