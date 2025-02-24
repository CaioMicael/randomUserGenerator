import { estClassViewComponentes } from "./estClassViewComponentes.js";

/**
 * Esta classe é responsável por funções relacionadas a Fetch.
 * Realizar Fetch, tratar fetch, tratar retorno fetch, etc.
 * @package webbased
 * @author Caio Micael Krieger
 * @since 06/02/2025
 */
export class estClassViewFetch {


    constructor() {
        this.oDadosEnviaFetch = {};
    }


    /**
     * Este método retorna a URL padrão de Fetch
     * @param {string} sController 
     * @param {int} iAcao 
     * @param {int} iProcessaDados 
     * @returns URL
     */
    getURLFetch(sController, iAcao, iProcessaDados) {
        return "../lib/estClassFormulario.php?destino="+sController+"&Acao="+iAcao+"&processaDados="+iProcessaDados;
    }


    /**
     * Este método alimenta o objeto oDadosEnviaFetch, e este objeto deve ser repassado 
     * no fetch como os dados do mesmo. Este método é específico para inputs.
     */
    addDadosFetchFromInputsTelaInclusao() {
        const aDadosInputLabel = document.querySelectorAll('.input-tela-inclusao');
        aDadosInputLabel.forEach((currentValue) => {
            this.oDadosEnviaFetch[`${currentValue.name}`] = `${currentValue.value}`;
        });
    }


    /**
     * Este método retorna se o fetch é uma mensagem ou não.
     * @param {string} sFetch 
     * @return {boolean}
     */
    isRetornoFetchMensagem(sFetch) {
        try {
            if (JSON.parse(sFetch)) {
                this.oFetch = JSON.parse(sFetch);
                if (this.oFetch.tipo[0]) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        catch {
            return false;
        }
    }


    /**
     * Este método é responsável por chamar os métodos que tratam a resposta do fetch.
     * @param {string} $sFetch 
     */
    trataRetornoFetch(sFetch) {
        this.oFetch = JSON.parse(sFetch);
        this.trataRetornoFetchByTipo(this.oFetch.tipo[0]);
    }


    /**
     * Este método trata a reposta do fetch, separando o mesmo por
     * tipo. Isso é importante pois conseguimos diferenciar o tipo de retorno
     * que o usuário terá (sucesso, alerta, erro...).
     * @param {object} oFetchTipo 
     */
    trataRetornoFetchByTipo(oFetchTipo) {
        this.oComponentes = new estClassViewComponentes();
        switch (oFetchTipo) {
            case 'exception':
                this.oComponentes.getComponenteDivRespostaFetch(this.oFetch.conteudo);
                break;
            case 'sucesso':
                this.oComponentes.getComponenteDivRespostaFetch(this.oFetch.conteudo);
                break;
            default:
                console.log('erro');
        }
    }


    /**
     * Este método realiza o ajax de alteração de registros.
     * @param {URL} caminho 
     * @param {string} dados 
     */
    async processaDadosAlterarAjax(caminho,dados) {
        var sRespostaFetch = await this.doAjaxCarrega(caminho,dados);
        this.trataRetornoFetch(sRespostaFetch);
    }


    /**
     * Este método retorna a tela de alteração de registro.
     * @param {URL} caminho 
     * @param {string} dados 
     */
    async doAjaxCarregaTelaAlteracao(caminho,dados) {
        var sRespostaFetch = await this.doAjaxCarrega(caminho,dados);
        if (this.isRetornoFetchMensagem(sRespostaFetch)) {
            this.trataRetornoFetch(sRespostaFetch);
        }
        else {
            this.oComponentes = new estClassViewComponentes();
            this.oComponentes.getComponenteDivRespostaFetch(sRespostaFetch);
        }
    }


    /**
     * Este método faz o fetch de fato, de acordo com caminho e dados repassados.
     * @param {string} caminho 
     * @param {object} dados 
     * @returns text
     */
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
                var respostaText = resposta.text();
                if (this.isRetornoFetchMensagem(respostaText)) {
                    this.trataRetornoFetch(respostaText);
                }
                return await respostaText;
            }
        } catch (error) {
            console.error("Erro na requisição AJAX: ", error);
            return "Erro ao carregar dados.";
        }
    }
}