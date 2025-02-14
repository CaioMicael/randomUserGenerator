import { estClassViewComponentes } from "./estClassViewComponentes.js";
import { estClassViewFetch } from "./estClassViewFetch.js";

/**
 * Classe estrutural de comportamento de rotinas do sistema
 * 
 * @author Caio Micael Krieger
 */
export class estClassViewComportamento {
    constructor(caminho,controller) {
        this.controller   = controller;
        this.oComponentes = new estClassViewComponentes();
        this.doAjaxTelaConsulta(caminho,"",false);
    }


/**********************************************************************************************************************/
/*************************************             ATRIBUTOS                 ******************************************/
/**********************************************************************************************************************/ 


    /**
     * Este método retira o overlay (fundo bloqueado) da tela.
     * @param {event} event 
     */
    fecharOverlay = (event) => {
        event.stopPropagation(); // Evita que o listener seja repassado para os elementos acima no DOM.
        this.setFundoTelaActiveAny('overlay');
    };
    

    initListeners() {
        const overlay = document.querySelector('.overlay');
        const closeButton = document.querySelector('.estButtonOK');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.fecharOverlay(event);
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
    
    
/**
 * Refatorar.
 * @param {element} element 
 */
    setFundoTelaDisabledAny(element) {
        element.classList.toggle('active');
    }
    

    /**
     * Este método retira o fundo de tela bloqueado.
     * @param {element} element 
     */
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


    /**
     * Este método altera a situação "disabled" do button
     * repassado, se estiver disabled altera para não disabled e vice-versa.
     * @param {button} button 
     */
    changeButtonDisabled(button) {
        if (button.disabled) {
            button.disabled = false;
        }
        else if (!button.disabled) {
            button.disabled = true;
        }
    }


    /**
     * Este método altera o button para disabled
     * @param {button} button 
     */
    changeButtonToDisabled(button) {
        if (!button.disabled) {
            button.disabled = true;
        }
    }


    /**
     * Este método tira o disabled de um button
     * @param {button} button 
     */
    changeButtonDisabledFalse(button) {
        if (button.disabled) {
            button.disabled = false;
        }
    }


    /**
     * Este método retorna o valor da linha de código
     * da linha selecionada na tela de selecionar registro.
     * @param {HTML} element 
     * @returns int
     */
    getValorLinhaSelecionada(element) {
        var linha = element.closest("tr");
        return linha.cells[1].innerText;
    }


    /**
     * Este método recebe um node list de checkbox e a checkbox
     * que estiver marcada sera setada no atributo checkboxChecked.
     * @param {Node} nodeCheckbox 
     * @return {element}
     */
    setCheckboxCheckedFromNodeList(nodeCheckbox) {
        nodeCheckbox.forEach(cb => {
            if (cb.checked) {
                this.checkboxChecked = cb;
                return;
            }
        })
    }

    
/**********************************************************************************************************************/
/*************************************             LISTENERS GERAIS                 ***********************************/
/**********************************************************************************************************************/ 
    

/**
 * Este método adiciona o comportamento de não poder
 * marcar mais de um checkbox de uma vez.
 */
    checkboxTelaSelecionarListener() {
        const aCheckbox = document.querySelectorAll('.estCheckboxTableSelecionar');
        if (aCheckbox) {
            aCheckbox.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    aCheckbox.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    })
                })
            })
        }
    }


    /**
     * Este método é um listener do checkbox da tela de seleção 
     * de registros, serve para habilitar/desabilitar o botão
     * "selecionar".
     */
    buttonChangeDisabledTelaSelecionarListener() {
        const aCheckbox = document.querySelectorAll('.estCheckboxTableSelecionar');
        var checkboxSituacao = false;
        if (aCheckbox) {
            aCheckbox.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked == true) {
                        this.changeButtonDisabledFalse(document.querySelector(".estButtonSelecionar"));
                    }
                })
            })
        }
    }


    /**
     * Este método é um listener do botão de selecionar da tela
     * de selecionar registro, aqui tem todos os eventos
     * que ocorrem ao clicar no botão de Selecionar.
     */
    buttonTelaSelecionarListener() {
        this.buttonSelecionar = this.oComponentes.getLastElementFromNode('estButtonSelecionar');
        if (this.buttonSelecionar) {
            this.buttonSelecionar.addEventListener('click', () => {
                this.setCheckboxCheckedFromNodeList(document.querySelectorAll('.estCheckboxTableSelecionar'));
                this.valorSelecionar = this.getValorLinhaSelecionada(this.checkboxChecked);
                this.fecharOverlay(event);
                //Aqui pegamos o valor selecionado pelo usuário e setamos no input.
                document.querySelector("[name= '"+this.oComponentes.nameInputLupaPreencher+"']").value = this.valorSelecionar;
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
            this.buttonFechar.addEventListener('click', this.fecharOverlay);
        }
        if (this.buttonFecharX) {
            this.buttonFecharX.addEventListener('click', () => {
                this.fecharOverlay(event);
            })
        }
    }
    
    
    /**
     * Este método é um listener do botão de incluir registro, também faz um fetch de envio
     * de registro.
     */
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


    /**
     * Este método é um listener do botão de trace
     * demonstrando o trace da mensagem que vem do backend.
     */
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
                //this.setFundoTelaActiveAny('overlay');
                this.fecharOverlay(event);
            })
        }
    }


    buttonLupaListener() {
        this.oComponentes.aButtonLupa = document.querySelectorAll("[class=input-lupa]");
        if (this.oComponentes.aButtonLupa) {
            this.oComponentes.aButtonLupa.forEach(button => {
                button.addEventListener('click', (event) => {
                    this.oComponentes.buttonLupa = event.currentTarget;
                    this.oComponentes.nameInputLupaPreencher = event.currentTarget.id;
                    this.oFetch = new estClassViewFetch;
                    this.doAjaxTelaConsulta(this.oFetch.getURLFetch(this.oComponentes.buttonLupa.name,5,1),null,true);
                })
            })
        }
    }


/**********************************************************************************************************************/
/*************************************             AJAX GERAIS                 ****************************************/
/**********************************************************************************************************************/ 
    
    
    /**
     * Este método realiza o ajax de inclusão de registros.
     * @param {string} caminho 
     * @param {string} dados 
     */
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
                var sRespostaFetch = telaConsulta;
                if (this.oFetch.isRetornoFetchMensagem(sRespostaFetch)) {
                    this.oFetch.trataRetornoFetch(sRespostaFetch);
                    this.buttonOKListener();
                    this.buttonTraceListener();
                }
                else {
                    this.oComponentes.getDivOverlaySeleciona(telaConsulta);
                    this.buttonChangeDisabledTelaSelecionarListener();
                    this.buttonFecharListener();
                    this.checkboxTelaSelecionarListener();
                    this.buttonTelaSelecionarListener();
                }
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


    /**
     * Necessário refatorar este método, esta fazendo mais do que a descrição dele.
     * @param {string} caminhoAjax 
     * @param {string} dados 
     * @returns 
     */
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
                this.buttonTraceListener();
            }
            else {
                return 'Erro ao carregar tela de inclusão!';
            }
        } catch (error) {
            console.error("Erro ao carregar tela de inclusão: ", error);
        }
    }


    /**
     * Este método retorna a tela de alteração de registro.
     * @param {string} caminho 
     * @returns HTML
     */
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
