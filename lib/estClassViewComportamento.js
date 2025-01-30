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
        
    }

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


    buttonFecharListener() {
        this.buttonFechar = document.querySelector('.estButtonFechar');
        if (this.buttonFechar) {
            this.buttonFechar.addEventListener('click', () => {
                const overlay = document.querySelector('.overlay');
                this.setFundoTelaActiveAny(overlay);
            });
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
            }
            else {
                return 'Erro ao carregar tela de inclusão!';
            }
        } catch (error) {
            console.error("Erro ao carregar tela de inclusão: ", error);
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
                return resposta.text();
            }
        } catch (error) {
            console.error("Erro na requisição AJAX: ", error);
            return "Erro ao carregar dados.";
        }
    }

}
