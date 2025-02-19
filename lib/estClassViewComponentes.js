export class estClassViewComponentes {
    constructor() {
        this.teste = 'a';
    }


    /**
     * Este método inclui o HTML repassado no parâmetro em uma div 
     * e coloca essa div no body do DOM.
     * @param {HTML} hConteudo 
     */
    getComponenteDivRespostaFetch(hConteudo) {
        const divResponse = document.createElement("div");
        divResponse.innerHTML = hConteudo; 
        document.body.appendChild(divResponse);
    }


    /**
     * Este método retorna um array com os inputs
     * que estão como required.
     * @returns array
     */
    getInputRequired() {
        return document.querySelectorAll(".input-tela-inclusao:not([type='button']):not([disabled])");
    }
    
    
    /**
     * Este método retorna o conteúdo repassado em uma div
     * overlay, ou seja, o fundo da tela ficará bloqueado.
     * @param {HTML} hConteudo 
     */
    getDivOverlaySeleciona(hConteudo) {
        const divOverlay          = document.createElement("div");
        const divOverlayConteudo  = document.createElement("div");
        const divContainerContent = document.createElement("div");

        divOverlay.classList.add("overlay");
        divOverlay.classList.toggle("active");

        divOverlayConteudo.classList.add("overlayConteudo");
        divOverlayConteudo.innerHTML = hConteudo;

        divContainerContent.classList.add("container-content-selecionar");

        divContainerContent.appendChild(divOverlayConteudo);
        divOverlay.appendChild(divContainerContent);
        document.body.appendChild(divOverlay);
    }


    /**
     * Este método retorna o úlitmo elemento de um querySelectorAll.
     * @param {string} sClass 
     */
    getLastElementFromNode(sClass) {
        var element = document.querySelectorAll('.'+sClass);
        if (element.length === 1) {
            return element[0];
        }
        else {
            return element[element.length - 1];
        }
    }


    /**
     * Este método gera um destaque em vermelho
     * no input repassado, para que o usuário
     * perceba e preencha o mesmo.
     * @param {HTML} xComponente 
     */
    destacaInputVazio(xComponente) {
        xComponente.style.border = "1px solid red";
    }


    setValorElemento(element,valor) {
        element.value = valor;
    }


/**********************************************************************************************************************/
/*************************************             GET COMPONENTES                  ***********************************/
/**********************************************************************************************************************/ 

/**
 * Este método retorna o button de selecionar registro.
 * @returns HTML
 */
    getComponenteButtonSelecionar() {
        return document.querySelector(".estButtonSelecionar");
    }
}