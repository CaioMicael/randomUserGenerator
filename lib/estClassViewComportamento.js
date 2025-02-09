import { estClassViewComponentes } from "./estClassViewComponentes.js";
import { estClassViewFetch } from "./estClassViewFetch.js";

export class estClassViewComportamento {
    constructor(caminho,controller) {
        this.controller   = controller;
        this.oComponentes = new estClassViewComponentes();
        this.doAjaxTelaConsulta(caminho,"",false);
    }

    initListeners() {
        const overlay = document.querySelector('.overlay');
        const closeButton = document.querySelector('.estButtonOK');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.setFundoTelaActiveAny(overlay);
                overlay.remove();
            })
        }


        const overlayAlerta     = document.querySelector('.overlay');
        const closeButtonAlerta = document.querySelector('.estButtonOK');
        if (closeButtonAlerta) {
            closeButtonAlerta.addEventListener('click', () => {
                this.setFundoTelaActiveAny(overlayAlerta);
                overlayAlerta.remove();
            })
        }


        const checkbox = document.querySelector('.estCheckboxTable');
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                this.changeButtonDisabled(document.querySelector('.estButtonAlterar'));
                this.changeButtonDisabled(document.querySelector('.estButtonExcluir'));
            })
        }


        const buttoIncluir = document.querySelector('.estButtonIncluir');
        if (buttoIncluir) {
            const caminho = "../lib/estClassFormulario.php?destino="+this.controller+"&Acao=1&processaDados=0";
            const dados   = 'Cidade';

            buttoIncluir.addEventListener('click', async () => {
                this.doAjaxTelaInclusao(caminho,dados);
            });
        }
        
    }


/**********************************************************************************************************************/
/*************************************             COMPORTAMENTOS GERAIS                 ******************************/
/**********************************************************************************************************************/ 
    
    
    setFundoTelaDisabledAny(element) {
        element.classList.toggle('active');
    }
    
    setFundoTelaActiveAny(element) {
        var overlay = document.querySelectorAll('.'+element);
        if (overlay.length == 1) {
            overlay[0].classList.remove('active');
            overlay[0].remove();
        }
        else {
            overlay = overlay[overlay.length - 1];
            overlay.classList.remove('active');
            overlay.remove();
        }
    }


    changeButtonDisabled(button) {
        if (button.disabled) {
            button.disabled = false;
        }
        else if (!button.disabled) {
            button.disabled = true;
        }
    }

    
/**********************************************************************************************************************/
/*************************************             LISTENERS GERAIS                 ***********************************/
/**********************************************************************************************************************/ 
    

/**
 * Este método é um listener do checkbox da tela de seleção 
 * de registros, serve para habilitar/desabilitar o botão
 * "selecionar".
 */
    buttonChangeDisabledTelaSelecionarListener() {
        const checkbox = document.querySelector('.estCheckboxTableSelecionar');
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                this.changeButtonDisabled(document.querySelector(".estButtonSelecionar"));
            })
        }
    }


    /**
     * Este método é um listener dos botões de fechar, fecha o overlay
     * que estiver active.
     */
    buttonFecharListener() {
        this.buttonFechar  = this.oComponentes.getLastElementFromNode('estButtonFechar');
        this.buttonFecharX = this.oComponentes.getLastElementFromNode('estButtonFecharX');
        if (this.buttonFechar) {
            this.buttonFechar.addEventListener('click', () => {
                this.setFundoTelaActiveAny('overlay');
            });
        }
        if (this.buttonFecharX) {
            this.buttonFecharX.addEventListener('click', () => {
                this.setFundoTelaActiveAny('overlay');
            })
        }
    }
    
    
    buttonIncluirRegistroListener() {
        this.buttonIncluirRegistro = document.querySelector('.estButtonIncluirRegistro');
        if (this.buttonIncluirRegistro) {
            this.buttonIncluirRegistro.addEventListener('click', async () => {
                this.oFetch = new estClassViewFetch();
                this.oFetch.addDadosFetchFromInputsTelaInclusao();
                // Se o botão de incluir registro for clicado, enviamos um fetch com os dados do formulário.
                const resposta = await this.processaDadosIncluirAjax("../lib/estClassFormulario.php?destino="+this.controller+"&Acao=1&processaDados=1", this.oFetch.oDadosEnviaFetch);
                this.buttonTraceListener();
                this.buttonOKListener();
            })
        }
    }


    buttonTraceListener() {
        this.buttonTrace = document.querySelector('.estButtonTrace');
        if (this.buttonTrace) {
            this.buttonTrace.addEventListener('click', () => {
                this.spanTrace = document.querySelector('.span-button-trace');
                if (this.spanTrace) {
                    if (this.spanTrace.style.display == 'none') {
                        this.spanTrace.removeAttribute('style');
                        this.spanTrace.setAttribute('style','display: block;');
                    }
                    else if (this.spanTrace.style.display == 'block') {
                        this.spanTrace.removeAttribute('style');
                        this.spanTrace.setAttribute('style','display: none;');
                    }
                }
            }) 
        }
    }


    buttonOKListener() {
        this.buttonOK = document.querySelector('.estButtonOK');
        if (this.buttonOK) {
            this.buttonOK.addEventListener('click', () => {
                this.setFundoTelaActiveAny('overlay');
            })
        }
    }


    buttonLupaListener() {
        this.buttonLupa = document.querySelector(".input-lupa");
        if (this.buttonLupa) {
            this.buttonLupa.addEventListener('click', () => {
                this.oFetch = new estClassViewFetch;
                this.doAjaxTelaConsulta(this.oFetch.getURLFetch(this.buttonLupa.name,5,1),null,true);
            })
        }
    }


/**********************************************************************************************************************/
/*************************************             AJAX GERAIS                 ****************************************/
/**********************************************************************************************************************/ 
    
    
    async processaDadosIncluirAjax(caminho,dados) {
        this.oFetch = new estClassViewFetch();
        var sRespostaFetch = await this.oFetch.doAjaxCarrega(caminho,dados);
        this.oFetch.trataRetornoFetch(sRespostaFetch);
    }
    

    /**
     * Este método chama a tela de consulta do controller repassado.
     * Se o bSelecionaRegistros for passado como true, retorna a view de selecionar registro.
     * @param {string} caminhoAjax 
     * @param {string} dados 
     * @param {boolean} bSelecionaRegistros - Indica se é uma tela de selecionar registros.
     * @returns HTML
     */
    async doAjaxTelaConsulta(caminhoAjax, dados, bSelecionaRegistros) {
        this.oFetch = new estClassViewFetch();
        try {
            const telaConsulta = await this.oFetch.doAjaxCarrega(caminhoAjax,dados);

            if (telaConsulta && !bSelecionaRegistros) {
                const divResponse = document.createElement("div");
                divResponse.innerHTML = telaConsulta; 
                document.body.appendChild(divResponse);

                this.initListeners();
            }
            else if (telaConsulta && bSelecionaRegistros) {
                this.oComponentes.getDivOverlaySeleciona(telaConsulta);
                this.buttonChangeDisabledTelaSelecionarListener();
                this.buttonFecharListener();
            }
            else {
                return 'Erro ao carregar tela!';
            }
        } catch (error) {
            console.error("Erro ao carregar tela: ", error);
        }
    }
    
    doAjaxTelaAlteracao(caminhoAjax) {
        try {
            
        } catch (error) {
            return "Erro ao carregar tela de alteração!";
        }
    }


    async doAjaxTelaInclusao(caminhoAjax,dados) {
        this.oFetch = new estClassViewFetch();
        try {
            const telaInclusao = await this.oFetch.doAjaxCarrega(caminhoAjax,dados);

            if (telaInclusao) {
                const divResponse = document.createElement("div");
                divResponse.innerHTML = telaInclusao; 
                document.body.appendChild(divResponse);
                
                const overlay = document.querySelector('.overlay');
                this.setFundoTelaDisabledAny(overlay);
                
                this.buttonFecharListener();
                this.buttonIncluirRegistroListener();
                this.buttonLupaListener();
            }
            else {
                return 'Erro ao carregar tela de inclusão!';
            }
        } catch (error) {
            console.error("Erro ao carregar tela de inclusão: ", error);
        }
    }


    async getTelaAlteracao(caminho) {
        this.oFetch = new estClassViewFetch();
        try {
            const resposta = await this.oFetch.doAjaxCarrega(caminho);
            return resposta;
        } catch (error) {
            console.error("Erro ao carregar dados: ",error);
            return "Erro ao carregar dados.";
        }
    }

}
