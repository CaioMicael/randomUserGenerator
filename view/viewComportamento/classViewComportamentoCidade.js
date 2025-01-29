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
            const caminho = "../lib/estClassFormulario.php?Controller=Cidade&Acao=1";
            const dados   = 'Cidade';

            buttoIncluir.addEventListener('click', async () => {
                this.doAjaxTelaInclusao(caminho,dados);
            });
        }
    }
}  
new classViewComportamentoCidade;