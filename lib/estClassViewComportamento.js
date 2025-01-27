export class estClassViewComportamento {
    constructor() {
        this.table = document.getElementsByTagName('table');
        this.initListeners();
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


        const checkbox = document.querySelector('.estCheckboxTable');
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                this.changeButtonDisabled(document.querySelector('.estButtonAlterar'));
                this.changeButtonDisabled(document.querySelector('.estButtonExcluir'));
            })
        }


        //const buttonIncluir = document.querySelector('.estButtonIncluir');
        //if (buttonIncluir) {
        //    buttonIncluir.addEventListener('click', () =>  {
        //        this.setFundoTelaDisabledAny(document.querySelector('.overlay'));
        //    })
        //}
    }

    setFundoTelaDisabledAny(element) {
        element.classList.toggle('active');
    }
    
    setFundoTelaActiveAny(element) {
        element.classList.remove('active');
    }

    changeButtonDisabled(button) {
        if (button.disabled) {
            button.disabled = false;
        }
        else if (!button.disabled) {
            button.disabled = true;
        }
    }


    async getTelaInclusao(caminho) {
        try {
            const resposta = await this.getTelaInclusaoAjax(caminho);
            return resposta;
        } catch (error) {
            console.error("Erro ao carregar dados: ", error);
            return "Erro ao carregar dados.";
        }
    }


    getTelaInclusaoAjax(caminho) {
        return this.doAjaxCarrega(caminho);
    }

    buttonFecharListener(buttonClass) {
        const overlay = document.querySelector('.overlay active');
        const button = document.querySelector('.' + buttonClass);
        if (button) {
            button.addEventListener('click', () => {
                this.setFundoTelaActiveAny(overlay);
                overlay.remove();
            })
        }
    }


    doAjaxCarrega(caminho) {
        return new Promise((resolve, reject) => {
            let xmlhttp       = new XMLHttpRequest();
            const method      = "GET";
            const url         = caminho;
            
            xmlhttp.onreadystatechange = () => {
                if (xmlhttp.readyState === XMLHttpRequest.DONE) {
                    const status = xmlhttp.status;
                    if (status === 200) {
                        const resposta = xmlhttp.response;
                        resolve(resposta);
                    } else {
                        reject("Erro ao tentar carregar os dados!");
                    }
                }
            };
            
            xmlhttp.open(method, url, true);
            xmlhttp.send();
        });
    }

}
