import { estClassViewComportamento } from '../../lib/estClassViewComportamento.js';

class classViewComportamentoCidade extends estClassViewComportamento {
    constructor() {
        super();
        this.initMensagemListener();
    }

    initMensagemListener() {
        const overlay = document.querySelector('.overlayEstMensagem');
        if (overlay) {
            this.setFundoTelaDisabled();
        }
    }

    setFundoTelaDisabled() {
        super.setFundoTelaDisabled();
    }

    setFundoTelaActive() {
        super.setFundoTelaActive();
    
    } 
}  
new classViewComportamentoCidade;