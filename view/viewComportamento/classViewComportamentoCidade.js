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
    }

    setFundoTelaDisabledAny(element) {
        super.setFundoTelaDisabledAny(element);
    }
    
    setFundoTelaActiveAny(element) {
        super.setFundoTelaActiveAny(element);
    }
}  
new classViewComportamentoCidade;