import { estClassViewComportamento } from "../../lib/estClassViewComportamento.js";

/**
 * Classe de comportamento da view Pais.
 * @since 09/03/2025
 * @author Caio Micael Krieger
 */
class ClassViewComportamentoPais extends estClassViewComportamento {
    constructor() {
        super("../lib/estClassFormulario.php?destino=Pais&Acao=4&processaDados=0", "Pais");
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
new ClassViewComportamentoPais;