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

        const button = document.querySelector('.estButtonFechar');
        if (button) {
            button.addEventListener('click', () => {
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

        const buttonIncluir = document.querySelector('.estButtonIncluir');
        if (buttonIncluir) {
            buttonIncluir.addEventListener('click', () =>  {
                this.getTelaInclusao('teste');
                this.setFundoTelaDisabledAny(document.querySelector('.overlay'));
            })
        }
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


    getTelaInclusao(form) {
        const divOverlay    = document.createElement("div");
        const divContainer  = document.createElement("div");
        const divContent    = document.createElement("div");
        const buttonIncluir = document.createElement("button");
        const buttonFechar  = document.createElement("button");
        const testemsg      = document.createElement("p");

        divOverlay.classList.add('overlay');
        divContainer.classList.add('container-content-inclusao');
        divContent.classList.add('overlayConteudo');
        buttonIncluir.classList.add('estButtonIncluir');
        buttonFechar.classList.add("estButtonFechar");
        buttonIncluir.textContent = "Incluir";
        buttonFechar.textContent = "Fechar";
        testemsg.textContent = "teste";

        divOverlay.appendChild(divContainer);
        divContainer.appendChild(divContent);
        divContent.appendChild(testemsg);
        divContent.appendChild(buttonIncluir);
        divContent.appendChild(buttonFechar);
        document.body.appendChild(divOverlay);
    }

    buttonFecharListener(buttonClass) {
        const overlay = document.querySelector('.overlay');
        const button = document.querySelector('.' + buttonClass);
        if (button) {
            button.addEventListener('click', () => {
                this.setFundoTelaActiveAny(overlay);
                overlay.remove();
            })
        }
    }

}
