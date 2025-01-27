<?php
namespace lib;

require_once '../autoload.php';

class estClassViewManutencao {
    protected string $sTituloRotina;
    protected array  $aAcoes;
    protected string $sTabelaRegistrosConsulta;
    protected string $sTituloTelaInclusao;
    private $html;


    /**
     * Este método cria uma tabela no front end de acordo com dados recebidos.
     * 
     * @param string $sTituloTabela
     * @param array  $aColunas
     * @param array  $aDados
     * @return HTML
     */
    protected function createTable($aDados, $aAcoes) {
        if (empty($aDados)) {
          return "<p><strong>Nenhum dado disponível para exibição.</strong></p>";
      }
      $html = $this->getStyleEstrutural();

      $html .= "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse;'>";

      $html .= $this->getTableHead($aDados, $aAcoes);

      $html .= "<tr>";

      $html .= $this->createColunaTable('');

      foreach (array_keys($aDados[0]) as $chave) {     
          $html .= "<th style='background-color: #f2f2f2; padding: 8px;'>" . htmlspecialchars($chave) . "</th>";
      }

      $html .= "</tr>";
      
      foreach ($aDados as $linha) {
          $html .= "<tr>";
          $html .= $this->createColunaCheckbox();
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
            $result = $result.'<button class="estButtonIncluir">Incluir</button>';
            break;
          case 2:
            $result = $result.'<button class="estButtonAlterar" disabled>Alterar</button>';
            break;
          case 3:
            $result = $result.'<button class="estButtonExcluir" disabled>Excluir</button>';
            break;
        }
      }
      return $result;
    }


    /**
     * Este método retorna a quantidade de chaves de um array associativo,
     * podendo ser usado para contar quantidade de colunas.
     * 
     * @param array $aDados
     * @return int
     */
    protected function getQuantidadeColunas($aDados) {
      return count(array_keys($aDados[0]));
    }


    /**
     * Este método realiza a criação de uma coluna
     * de checkbox, para selecionar registros de uma tabela.
     * 
     * @return HTML
     */
    private function createColunaCheckbox() {
      return "<td>
                <input class='estCheckboxTable' type = 'checkbox'>
              </td>";
    }


    /**
     * Esta função retorna o header da tabela, já colocando as ações passadas.
     * 
     * @param array $aDados
     * @param array $aAcoes
     * @return HTML
     */
    private function getTableHead($aDados, $aAcoes) {
      return "<thead style='font-weight: bold; font-size: 1.2em; margin-bottom: 10px;'>
                  <tr>
                    <th colspan=".$this->getQuantidadeColunas($aDados)+1 ." style='text-align: center';>$this->sTituloRotina</th>
                  </tr>
                  <tr>
                    <td colspan=".$this->getQuantidadeColunas($aDados)+1 .">
                      ". $this->getAcaoTela($aAcoes). "
                    </td>
                  </tr>
                </thead>";
    }


    /**
     * Este método realiza a criação de uma coluna em um table.
     * 
     * @param string $content
     * @return HTML
     */
    private function createColunaTable($content) {
      return "<th style='background-color: #f2f2f2; padding: 8px;'>$content</th>";
    }


    private function getStyleEstrutural() {
      return "<link rel='stylesheet' href='../lib/styles/styleEstClassViewManutencao.css'>";
    }


    protected function getTelaInclusao($title) {
      return 
            "<div class='overlay'>
                <div class='container-content-inclusao'>
                    <div class ='overlayConteudo'>
                        <h1>$title</h1>
                        <p>Incluir registro</p>
                        <button class='estButtonIncluir'>Incluir</button>
                        <button class='estButtonFechar'>Fechar</button>
                    </div>
                </div>
             </div>
            ";
    }


    private function getCampoLabelInclusao($aLabel) {
      return "<label for='inum'>Número: </label>
              <input type= id= required>";
    }


    private function getCampoLabelInclusaoString() {
      return "<label for='inum'>: </label>
              <input type='text' required>";
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 


    protected function getTituloRotina() {
      return $this->sTituloRotina;
    }

    protected function getAcoes() {
      return $this->aAcoes;
    }

    protected function getTabelaRegistros() {
      return $this->sTabelaRegistrosConsulta;
    }

    protected function getTituloTelaInclusao() {
      return $this->sTituloTelaInclusao;
    }

    protected function setTituloRotina($titulo) {
      $this->sTituloRotina = $titulo;
    }

    protected function setAcoes($aAcoes) {
      $this->aAcoes = $aAcoes;
    }

    protected function setTabelaRegistros($tabela) {
      $this->sTabelaRegistrosConsulta = $tabela;
    }

    protected function setTituloTelaInclusao($titulo) {
      $this->sTituloTelaInclusao = $titulo;
    }
}

?>