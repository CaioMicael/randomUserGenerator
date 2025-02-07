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
     * Este método é responsável por chamar os métodos que tratam a resposta do fetch.
     * @param {string} $sFetch 
     */
    trataRetornoFetch($sFetch) {
        this.oFetch = JSON.parse($sFetch);
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
                return await resposta.text();
            }
        } catch (error) {
            console.error("Erro na requisição AJAX: ", error);
            return "Erro ao carregar dados.";
        }
    }
}