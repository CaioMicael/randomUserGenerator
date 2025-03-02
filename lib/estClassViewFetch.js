import { estClassViewComponentes } from "./estClassViewComponentes.js";
import { estClassViewComportamento } from "./estClassViewComportamento.js";

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


    isJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
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
        this.oFetch = sFetch;
        try {
            if (this.isJSON(sFetch)) {
                this.oFetch = JSON.parse(sFetch);
            }
            if (this.oFetch.tipo[0]) {
                return true;
            } else {
                return false;
            }
        } catch {
            return false;
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
            
            if (resposta.status === 200) {
                var respostaText = await resposta.text();
                return await respostaText;
            }
        } catch (error) {
            console.error("Erro na requisição AJAX: ", error);
            return "Erro ao carregar dados.";
        }
    }
}