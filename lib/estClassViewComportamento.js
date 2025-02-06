import { estClassViewComponentes } from "./estClassViewComponentes.js";
import { estClassViewFetch } from "./estClassViewFetch.js";

export class estClassViewComportamento {
    constructor(caminho,controller) {
        this.controller   = controller;
        this.oComponentes = new estClassViewComponentes();
        this.doAjaxTelaConsulta(caminho,"");
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
        const overlay = document.querySelector('.'+element);
        overlay.classList.remove('active');
        overlay.remove();
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
    
    
    buttonFecharListener() {
        this.buttonFechar  = document.querySelector('.estButtonFechar');
        this.buttonFecharX = document.querySelector('.estButtonFecharX');
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
                this.setFundoTelaActiveAny('overlay-alerta');
            })
        }
    }


/**********************************************************************************************************************/
/*************************************             AJAX GERAIS                 ****************************************/
/**********************************************************************************************************************/ 
    
    
    async processaDadosIncluirAjax(caminho,dados) {
        var sRespostaFetch = await this.doAjaxCarrega(caminho,dados);
        this.trataRetornoFetch(sRespostaFetch);
    }
    
    async doAjaxTelaConsulta(caminhoAjax,dados) {
        try {
            const telaConsulta = await this.doAjaxCarrega(caminhoAjax,dados);

            if (telaConsulta) {
                const divResponse = document.createElement("div");
                divResponse.innerHTML = telaConsulta; 
                document.body.appendChild(divResponse);

                this.initListeners();
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
        try {
            const telaInclusao = await this.doAjaxCarrega(caminhoAjax,dados);

            if (telaInclusao) {
                const divResponse = document.createElement("div");
                divResponse.innerHTML = telaInclusao; 
                document.body.appendChild(divResponse);
                
                const overlay = document.querySelector('.overlay');
                this.setFundoTelaDisabledAny(overlay);
                
                this.buttonFecharListener();
                this.buttonIncluirRegistroListener();
            }
            else {
                return 'Erro ao carregar tela de inclusão!';
            }
        } catch (error) {
            console.error("Erro ao carregar tela de inclusão: ", error);
        }
    }


    trataRetornoFetch($sFetch) {
        this.oFetch = JSON.parse($sFetch);
        this.trataRetornoFetchByTipo(this.oFetch.tipo[0]);
    }


    /**
     * Este método trata a reposta do fetch, separando o mesmo por
     * tipo. Isso é importante pois conseguimos diferenciar o tipo de retorno
     * que o usuário terá (sucesso, alerta, erro...).
     * @param {object} oFetchTipo 
     */
    trataRetornoFetchByTipo(oFetchTipo) {
        switch (oFetchTipo) {
            case 'exception':
                this.oComponentes.getComponenteDivRespostaFetch(this.oFetch.conteudo);
                break;
            default:
                console.log('erro');
        }
    }


    async getTelaAlteracao(caminho) {
        try {
            const resposta = await this.doAjaxCarrega(caminho);
            return resposta;
        } catch (error) {
            console.error("Erro ao carregar dados: ",error);
            return "Erro ao carregar dados.";
        }
    }


    async doAjaxCarrega(caminho,dados) {
        try {
            const resposta = await fetch(caminho, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({dados})
                
            });
            
            if (resposta) {
                return await resposta.text();
            }
        } catch (error) {
            console.error("Erro na requisição AJAX: ", error);
            return "Erro ao carregar dados.";
        }
    }

}
