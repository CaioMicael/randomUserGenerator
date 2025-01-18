<?php
namespace lib;

require_once '../autoload.php';

class estClassViewManutencao {
    private $html;


    /**
     * Este método cria uma tabela no front end de acordo com dados recebidos.
     * 
     * @param string $sTituloTabela
     * @param array  $aColunas
     * @param array  $aDados
     * @return html
     */
    protected function createTable($sTituloTabela, $aDados) {
        if (empty($aDados)) {
          return "<p><strong>Nenhum dado disponível para exibição.</strong></p>";
      }
      $html = "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse;'>";

      $html .= "<thead style='font-weight: bold; font-size: 1.2em; margin-bottom: 10px;'>
                  <tr>
                    <th colspan=".count(array_keys($aDados[0]))." style='text-align: center';>$sTituloTabela</th>
                  </tr>
                  <tr>
                    <td>
                      ". $this->getAcaoTela([estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]). "
                    </td>
                  </tr>
                </thead>";

      $html .= "<tr>";

      foreach (array_keys($aDados[0]) as $chave) {
          $html .= "<th style='background-color: #f2f2f2; padding: 8px;'>" . htmlspecialchars($chave) . "</th>";
      }

      $html .= "</tr>";
      
      foreach ($aDados as $linha) {
          $html .= "<tr>";
          foreach ($linha as $valor) {
              $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
          }
          $html .= "</tr>";
      }
    
      $html .= "</table>";
    
      return $html;
    }


    /**
     * Este método pega o Enum de ações repassadas e retorna as
     * mesmas para inserção em algum componente.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    protected function getAcaoTela($aAcoes) {
      $result = '';
      foreach ($aAcoes as $oAcoes) {
        switch ($oAcoes->value) {
          case 1:
            $result = $result.'<button>Incluir</button>';
            break;
          case 2:
            $result = $result.'<button>Alterar</button>';
            break;
          case 3:
            $result = $result.'<button>Excluir</button>';
            break;
        }
      }
      return $result;
    }
}

/*
      <table>
        <thead>
          <th>teste</th>
        </thead>
        <tbody>
          <tr>
            <td>teste</td>
            <td>teste</td>
          </tr>
          <tr>
            <td>teste</td>
          </tr>
        </tbody>
      </table>
*/      

?>