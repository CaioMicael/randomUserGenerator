export class estClassViewComportamento {
    constructor() {
        this.initListeners();
    }

    initListeners() {
        const closeButton = document.querySelector('.estButtonOK');
        if (closeButton) {
            closeButton.addEventListener('click', () => this.setFundoTelaActive());
        }

        const checkbox = document.querySelector('.estCheckboxTable');
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                this.changeButtonDisabled(document.querySelector('.estButtonAlterar'));
                this.changeButtonDisabled(document.querySelector('.estButtonExcluir'));
            })
        }
    }

    setFundoTelaDisabled() {
        const overlay = document.querySelector('.overlayEstMensagem');
        overlay.classList.toggle('active');
    }
    
    setFundoTelaActive() {
        const overlay = document.querySelector('.overlayEstMensagem');
        overlay.classList.remove('active');
    }

    changeButtonDisabled(button) {
        if (button.disabled) {
            button.disabled = false;
        }
        else if (!button.disabled) {
            button.disabled = true;
        }
    }

}
