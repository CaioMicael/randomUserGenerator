export class estClassViewComponentes {
    constructor() {
        this.teste = 'a';
    }


    /**
     * Este método inclui o HTML repassado no parâmetro em uma div 
     * e coloca essa div no body do DOM.
     * @param {HTML} hConteudo 
     */
    getComponenteDivRespostaFetch(hConteudo) {
        const divResponse = document.createElement("div");
        divResponse.innerHTML = hConteudo; 
        document.body.appendChild(divResponse);
    }
    
    
    /**
     * Este método retorna o conteúdo repassado em uma div
     * overlay, ou seja, o fundo da tela ficará bloqueado.
     * @param {HTML} hConteudo 
     */
    getDivOverlaySeleciona(hConteudo) {
        const divOverlay          = document.createElement("div");
        const divOverlayConteudo  = document.createElement("div");
        const divContainerContent = document.createElement("div");

        divOverlay.classList.add("overlay");
        divOverlay.classList.toggle("active");

        divOverlayConteudo.classList.add("overlayConteudo");
        divOverlayConteudo.innerHTML = hConteudo;

        divContainerContent.classList.add("container-content");

        divContainerContent.appendChild(divOverlayConteudo);
        divOverlay.appendChild(divContainerContent);
        document.body.appendChild(divOverlay);
    }
}