import { estClassViewComportamento } from '../../lib/estClassViewComportamento.js';

class classViewComportamentoCidade extends estClassViewComportamento {

    constructor(nada) {
        super('teste');
    }

    setFundoTelaDisabled() {
        super.setFundoTelaDisabled();
    }

    setFundoTelaActive() {
        super.setFundoTelaActive();
    }

}
var viewComportamentoCidadeInstance = new classViewComportamentoCidade('teste');
viewComportamentoCidadeInstance.setFundoTelaDisabled();