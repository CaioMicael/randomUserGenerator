export class estClassViewFetch {

    constructor() {
        this.teste = 'a';
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
}