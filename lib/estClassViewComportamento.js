export class estClassViewComportamento {

    constructor(overlayEstMensagem) {
        this.overlayEstMensagem = overlayEstMensagem;
    }

    setFundoTelaDisabled() {
        const overlay = document.querySelector('.overlayEstMensagem');
        overlay.classList.toggle('active');
    }
    
    setFundoTelaActive() {
        const overlay = document.querySelector('.overlayEstMensagem');
        overlay.classList.toggle('disabled');
    }

}
