import { estClassViewComportamento } from "./estClassViewComportamento.js";

/**
 * Esta classe contém todos os componentes do sistema.
 * Os métodos get podem ser utilizados para pegar estes componentes.
 * Outros métodos podem ser usados para por exemplo criar divs.
 * 
 * @package webbased
 * @author Caio Micael Krieger
 */
export class estClassViewComponentes {
    constructor() {
        this.teste = 'a';
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
     * Este método coloca o conteúdo repassado em uma div overlay.
     * @param {HTML} hConteudo 
     */
    putContentInDivOverlay(hConteudo) {
        const divResponse = document.createElement("div");
        divResponse.innerHTML = hConteudo; 
        document.body.appendChild(divResponse);
    }
    
    
    /**
     * Este método retorna o úlitmo elemento de um querySelectorAll.
     * @param {string} sClass - Informar o nome da classe do elemento sem ponto.
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
     * Este método retorna o elemento "tr" mais próximo do elemento repassado.
     * @param {element} element 
     * @returns HTML
     */
    getClosestTR(element) {
        return element.closest("tr");
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


    /**
     * Este método remove o elemento repassado no parâmetro.
     * @param {element} element 
     */
    destroyElement(element) {
        element.remove();
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
    
    
    /**
     * Este método retorna um array com todos os checkbox da tela de
     * selecionar registro.
     * @returns {NodeList}
     */
   getAllComponenteCheckboxTelaSelecionar() {
       return document.querySelectorAll('.estCheckboxTableSelecionar');
    }

    
    /**
     * Este método retorna um array com todos os inputs
     * que estão como required.
     * @returns {NodeList}
     */
    getAllComponenteInputRequired() {
        return document.querySelectorAll(".input-tela-inclusao:not([type='button']):not([disabled])");
    }


    /**
     * Este método retorna o botão estrutural de alterar registro.
     * @returns HTML
     */
    getComponenteButtonAlterar() {
        return document.querySelector('.estButtonAlterar');
    }


    /**
     * Este método retorna o botão estrutural de excluir registro.
     * @returns HTML
     */
    getComponenteButtonExcluir() {
        return document.querySelector('.estButtonExcluir')
    }


    /**
     * Este método retorna um array com todos os checkbox
     * da table padrão de registros.
     * @returns {NodeList}
     */
    getAllComponenteCheckboxTable() {
        return document.querySelectorAll('.estCheckboxTable');
    }


    /**
     * Este método retorna a checkbox da table padrão que está marcada.
     * @returns HTML
     */
    getComponenteCheckboxTableChecked() {
        return document.querySelector('.estCheckboxTable:checked');
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
     * Este método retorna o valor do componente
     * @param {element} componente 
     * @returns {value}
     */
    getValorComponente(componente) {
        return componente.value;
    }

    /*********************************************************************************************************************
     ************************************* GET VALORES COMPONENTES *******************************************************
     *********************************************************************************************************************/

     /**
      * Este método retorna um JSON com os valores dos checkbox
      * que está marcada na tela de consulta padrão.
      * @returns {JSON}
      */
     getValoresComponenteCheckboxTableChecked() {
        var html = this.getClosestTR(this.getComponenteCheckboxTableChecked());
        var rows = html.querySelectorAll('td:not(:has(input))');
        var values = [];
        rows.forEach(row => {
            if (row.textContent.trim() !== '' || row.textContent.trim() !== null) {
                values.push(row.textContent.trim());
            }
        });
        return values;
     }
}

