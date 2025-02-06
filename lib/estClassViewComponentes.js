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
}