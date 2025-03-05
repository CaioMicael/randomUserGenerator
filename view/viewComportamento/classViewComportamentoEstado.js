import { estClassViewComportamento } from "../../lib/estClassViewComportamento.js";

class ClassViewComportamentoEstado extends estClassViewComportamento {
    constructor() {
        super("../lib/estClassFormulario.php?destino=Estado&Acao=4&processaDados=0", "Estado");
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
new ClassViewComportamentoEstado;