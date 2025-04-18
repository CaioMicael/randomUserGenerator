import { estClassViewComponentes } from "./estClassViewComponentes.js";
import { estClassViewFetch } from "./estClassViewFetch.js";

/**
 * Classe estrutural de comportamento de rotinas do sistema
 * 
 * @author Caio Micael Krieger
 */
export class estClassViewComportamento {
    constructor(caminho,controller) {
        this.caminho = caminho;
        this.controller   = controller;
        this.oComponentes = new estClassViewComponentes();
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


        const buttoIncluir = document.querySelector('.estButtonIncluir');
        if (buttoIncluir) {
            const caminho = "../lib/estClassFormulario.php?destino="+this.controller+"&Acao=1&processaDados=0";
            const dados   = 'Cidade';

            buttoIncluir.addEventListener('click', async () => {
                this.doAjaxTelaInclusao(caminho,dados);
            });
        }

        this.checkboxUnicaSelecaoListener(this.oComponentes.getAllComponenteCheckboxTable());
        this.buttonChangeDisabledUnicaSelecaoListener(
            this.oComponentes.getAllComponenteCheckboxTable(),
            Array(this.oComponentes.getComponenteButtonAlterar(),this.oComponentes.getComponenteButtonExcluir())
        );

        if (this.oComponentes.getComponenteButtonExcluir()) {
            this.oComponentes.getComponenteButtonExcluir().addEventListener('click', async () => {
                this.processaDadosExcluirAjax(
                    this.oFetch.getURLFetch(this.controller,3,1),
                    this.getValorLinhaSelecionada(this.oComponentes.getComponenteCheckboxTableChecked())
                )
            })
        }

        if (this.oComponentes.getComponenteButtonAlterar()) {
            this.oComponentes.getComponenteButtonAlterar().addEventListener('click', async () => {
                this.oFetch = new estClassViewFetch();
                await this.doAjaxCarregaTelaAlteracao(this.oFetch.getURLFetch(this.controller,2,0),0);
                this.getListenerTelaAlteracao();
            })
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
    changeButtonDisabledTrue(button) {
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


    /**
     * Este método verifica se os inputs que
     * estão marcados como required estão preenchidos.
     * Caso não esteja, destaca o campo em vermelho.
     */
    isInputsRequiredVazios() {
        var bCondicao;
        var aInputs = this.oComponentes.getAllComponenteInputRequired();
        aInputs.forEach(xInput => {
            if (xInput.value == null || xInput.value == '') {
                this.oComponentes.destacaInputVazio(xInput);
                bCondicao = true;
            }
        })
        if (bCondicao) {
            return true;
        }
        return false;
    }


    /**
     * Este método realiza o comportamento de apenas um único registro
     * poder ser selecionado para que seja habilitado o botão.
     * Para cada checkbox, ele irá verificar se está marcado,
     * se estiver ele seta o disabled como falso, caso contrário
     * seta o disabled como verdadeiro.
     * @param {NodeList} aButton 
     * @param {checkbox} checkbox 
     */
    checkboxUnicaSelecaoToDisabledButton(aButton, checkbox) {
        if (checkbox.checked == true) {
            aButton.forEach(button => {
                this.changeButtonDisabledFalse(button);
            })
        }
        else {
            aButton.forEach(button => {
                this.changeButtonDisabledTrue(button);
            })
        }
    }


    /**
     * Este método realiza o comportamento de não poder
     * marcar mais de uma checkbox de uma vez.
     * @param {NodeList} aCheckbox 
     */
    checkboxUnicaSelecaoComportamento(aCheckbox) {
        aCheckbox.forEach(cb => {
            if (cb !== this.checkboxChecked) {
                cb.checked = false;
            }
        })
    }


    /**
     * Este método realiza o comportamento do botão de confirmar alteração.
     */
    async comportamentoButtonConfirmarAlteracao() {
        this.oFetch = new estClassViewFetch();
        this.oFetch.addDadosFetchFromInputsTelaAlteracao();
        await this.processaDadosAlterarAjax(this.oFetch.getURLFetch(this.controller,2,1),this.oFetch.oDadosEnviaFetch);
    }

    
/**********************************************************************************************************************/
/*************************************             LISTENERS GERAIS                 ***********************************/
/**********************************************************************************************************************/ 
    

/**
 * Este método é um listener do comportamento
 * de seleção única de checkbox.
 * @param {NodeList} aCheckbox 
 */
    checkboxUnicaSelecaoListener(aCheckbox) {
        if (aCheckbox) {
            aCheckbox.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.checkboxChecked = event.target;
                    this.checkboxUnicaSelecaoComportamento(aCheckbox);   
                })
            })
        }
    }


    /**
     * Este método é um listener do checkbox repassado, onde
     * a ação deste listener é o comportamento de desabilitar/habilitar
     * os botões desejados repassados no parâmetro.
     * @param {NodeList} aButton 
     * @param {NodeList} aButton 
     */
    buttonChangeDisabledUnicaSelecaoListener(aCheckbox, aButton) {
        if (aCheckbox) {
            aCheckbox.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.checkboxUnicaSelecaoToDisabledButton(aButton,checkbox);
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
                if (!this.isInputsRequiredVazios()) {
                    this.oFetch = new estClassViewFetch();
                    this.oFetch.addDadosFetchFromInputsTelaInclusao();
                    // Se o botão de incluir registro for clicado, enviamos um fetch com os dados do formulário.
                    const resposta = await this.processaDadosIncluirAjax("../lib/estClassFormulario.php?destino="+this.controller+"&Acao=1&processaDados=1", this.oFetch.oDadosEnviaFetch);
                }
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


    /**
     * Este método é um listener do botão OK.
     * @param {boolean} bRefresh - Define se ao clicar no botão ele da um refresh na tela.
     */
    buttonOKListener(bRefresh) {
        this.buttonOK = document.querySelector('.estButtonOK');
        if (this.buttonOK) {
            this.buttonOK.addEventListener('click', () => {
                this.fecharOverlay(event);
                if (bRefresh) {
                    this.oComponentes.destroyElement(document.querySelector('table'));
                    this.doAjaxTelaConsulta(this.caminho,"",false);
                }
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


    /**
     * Este método é um listener do botão de confirmar alteração.
     */
    buttonConfirmarAlteracaoListener() {
        this.buttonConfirmarAlteracao = this.oComponentes.getComponenteButtonConfirmarAlteracao();
        if (this.buttonConfirmarAlteracao) {
            this.buttonConfirmarAlteracao.addEventListener('click', async () => {
                if (!this.isInputsRequiredVazios()) {
                    this.comportamentoButtonConfirmarAlteracao();
                }
            })
        }
    }


/**********************************************************************************************************************
 *************************************          LISTENER DE TELAS            ******************************************
 **********************************************************************************************************************/


    /**
     * Este método carrega os listeners dos botões de mensagem.
     * @param {boolean} bRefresh - Define se ao clicar no botão OK ele da um refresh na tela.
     */
    getListenerMensagem(bRefresh) {
        this.buttonOKListener(bRefresh);
        this.buttonTraceListener();
    }


    /**
     * Este método carrega os listeners da tela de alteração.
     */
    getListenerTelaAlteracao() {
        this.buttonFecharListener();
        this.buttonLupaListener();
        this.buttonConfirmarAlteracaoListener();
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
        var jResposta = await this.oFetch.doAjaxCarrega(caminho,dados);
        var oResposta = JSON.parse(jResposta);
        this.oComponentes.getComponenteDivRespostaFetch(oResposta.conteudo);
        this.addComportamentoMensagemByTipo(oResposta.tipo[0]);
    }


    /**
     * Este método realiza o ajax de exclusão de registro.
     * @param {URL} caminho 
     * @param {string} dados 
     */
    async processaDadosExcluirAjax(caminho,dados) {
        this.oFetch = new estClassViewFetch();
        var jResposta = await this.oFetch.doAjaxCarrega(caminho,dados);
        var oResposta = JSON.parse(jResposta);
        this.oComponentes.getComponenteDivRespostaFetch(oResposta.conteudo);
        this.addComportamentoMensagemByTipo(oResposta.tipo[0]);
    }


    /**
     * Este método realiza o ajax de alteração de registros.
     * @param {URL} caminho 
     * @param {string} dados 
     */
    async processaDadosAlterarAjax(caminho,dados) {
        this.oFetch = new estClassViewFetch();
        var jResposta = await this.oFetch.doAjaxCarrega(caminho,dados);
        var oResposta = JSON.parse(jResposta);
        this.oComponentes.getComponenteDivRespostaFetch(oResposta.conteudo);
        this.addComportamentoMensagemByTipo(oResposta.tipo[0]);
    }


    /**
     * Este método retorna a tela de alteração de registro.
     * @param {URL} caminho 
     * @param {string} dados 
     */
    async doAjaxCarregaTelaAlteracao(caminho,dados) {
        var jDados    = this.oComponentes.getValoresComponenteCheckboxTableChecked();
        this.oFetch   = new estClassViewFetch();
        var jResposta = await this.oFetch.doAjaxCarrega(caminho,jDados);
        var oResposta = JSON.parse(jResposta); 
        if (this.oFetch.isRetornoFetchMensagem(oResposta)) {
            this.oComponentes.getComponenteDivRespostaFetch(oResposta.conteudo);
            this.addComportamentoMensagemByTipo(oResposta.tipo[0]);
        }
        else {
            this.oComponentes.putContentInDivOverlay(oResposta);
            const overlay = document.querySelector('.overlay');
            this.setFundoTelaDisabledAny(overlay);
            this.buttonFecharListener();
        }
    }


    /**
     * Este método trata a reposta do fetch, separando o mesmo por
     * tipo e chamando o comportamento de cada tipo. 
     * Isso é importante pois conseguimos diferenciar o tipo de retorno
     * que o usuário terá (sucesso, alerta, erro...).
     * @param {object} oFetchTipo 
     */
    addComportamentoMensagemByTipo(oFetchTipo) {
        this.oComponentes = new estClassViewComponentes();
        switch (oFetchTipo) {
            case 'exception':
                this.getListenerMensagem(false);
                break;
            case 'sucesso':
                this.getListenerMensagem(true);
                break;
            default:
                console.log('erro');
        }
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
                    this.buttonChangeDisabledUnicaSelecaoListener(this.oComponentes.getAllComponenteCheckboxTelaSelecionar(), Array(this.oComponentes.getComponenteButtonSelecionar()));
                    this.buttonFecharListener();
                    this.checkboxUnicaSelecaoListener(this.oComponentes.getAllComponenteCheckboxTelaSelecionar());
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

}
