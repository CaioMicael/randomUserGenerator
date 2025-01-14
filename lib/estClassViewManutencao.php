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
    // Verifica se o array de dados está vazio
        if (empty($aDados)) {
          return "<p><strong>Nenhum dado disponível para exibição.</strong></p>";
      }
    
      // Início da tabela
      $html = "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse;'>";
      $html .= "<caption style='font-weight: bold; font-size: 1.2em; margin-bottom: 10px;'>$sTituloTabela</caption>";
    
      // Gera os cabeçalhos (baseado nas chaves do primeiro item do array)
      $html .= "<tr>";
      foreach (array_keys($aDados[0]) as $chave) {
          $html .= "<th style='background-color: #f2f2f2; padding: 8px;'>" . htmlspecialchars($chave) . "</th>";
      }
      $html .= "</tr>";
    
      // Gera as linhas de dados
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