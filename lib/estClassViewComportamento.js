export class estClassViewComportamento {
    constructor(caminho,controller) {
        this.controller = controller;
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
        element.classList.remove('active');
        element.remove();
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
                const overlay = document.querySelector('.overlay');
                this.setFundoTelaActiveAny(overlay);
            });
        }
        if (this.buttonFecharX) {
            this.buttonFecharX.addEventListener('click', () => {
                const overlay = document.querySelector('.overlay');
                this.setFundoTelaActiveAny(overlay);
            })
        }
    }
    
    
    buttonIncluirRegistroListener() {
        this.buttonIncluirRegistro = document.querySelector('.estButtonIncluirRegistro');
        if (this.buttonIncluirRegistro) {
            this.buttonIncluirRegistro.addEventListener('click', async () => {
                var oFetch = {};
                const aDadosInputLabel = document.querySelectorAll('.input-tela-inclusao');
                aDadosInputLabel.forEach(function (currentValue) {
                    oFetch[`${currentValue.name}`] = `${currentValue.value}`;
                });
                const resposta = await this.processaDadosIncluirAjax("../lib/estClassFormulario.php?destino="+this.controller+"&Acao=1&processaDados=1", oFetch);
                this.buttonTraceListener();
            })
        }
    }


    buttonTraceListener() {
        this.buttonTrace = document.querySelector('.estButtonTrace');
        if (this.buttonTrace) {
            this.buttonTrace.addEventListener('click', () => {
                this.spanTrace = document.querySelector('.span-button-trace');
                if (this.spanTrace) {
                    if (this.spanTrace.hasAttribute('style')) {
                        this.spanTrace.removeAttribute('style');
                    }
                    else if (!this.spanTrace.hasAttribute('style')) {
                        this.spanTrace.setAttribute('style','display: none;');
                    }
                }
            }) 
        }
    }
    

/**********************************************************************************************************************/
/*************************************             COMPONENTES                 ****************************************/
/**********************************************************************************************************************/ 

    getComponenteDivRespostaFetch(hConteudo) {
        const divResponse = document.createElement("div");
        divResponse.innerHTML = hConteudo; 
        document.body.appendChild(divResponse);
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


    trataRetornoFetchByTipo(oFetchTipo) {
        switch (oFetchTipo) {
            case 'exception':
                this.getComponenteDivRespostaFetch(this.oFetch.conteudo);
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
