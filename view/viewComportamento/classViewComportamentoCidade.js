import { estClassViewComportamento } from '../../lib/estClassViewComportamento.js';

class classViewComportamentoCidade extends estClassViewComportamento {
    constructor() {
        super("../lib/estClassFormulario.php?destino=Cidade&Acao=4&processaDados=0", "Cidade");
        this.doAjaxTelaConsulta(this.caminho,"",false);
        this.initMensagemListener();
    }

    initMensagemListener() {
        const overlay = document.querySelector('.overlay');
        if (overlay) {
            this.setFundoTelaDisabledAny(overlay);
        }
    }
}  
new classViewComportamentoCidade;