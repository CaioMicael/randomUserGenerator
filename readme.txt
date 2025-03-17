[Requisitos para rodar o sistema]:
Para rodar o sistema é necessário PHP 8.2 e postgres em qualquer versão.

[Como rodar o projeto]:
Para rodar, basta criar um schema webbased no postgres e rodar os scrips dentro de lib/.env/scriptsBD.env.
A connection string pode ser alterada em lib/.env/db.env.
Alterando a connection string já basta para a conexão ao banco de dados rodar corretamente.
Para testar a APi, basta acessar o arquivo ClassModelAPIUserGenerator.php, ele irá automaticamente executar a API e retornar um resultado.
Com isso, basta acessar as views que os dados executados pela API estarão disponíveis para alterar nos CRUDs.

[Observações sobre o projeto]:
Atualmente somente as views Estado, Cidade e País funcionam 100%, as demais estão em implementação ainda.