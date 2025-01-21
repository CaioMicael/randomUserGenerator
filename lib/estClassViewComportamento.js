export class estClassViewComportamento {
    constructor() {
        this.initListeners();
    }

    initListeners() {
        const closeButton = document.querySelector('.estButtonOK');
        if (closeButton) {
            closeButton.addEventListener('click', () => this.setFundoTelaActive());
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

}
