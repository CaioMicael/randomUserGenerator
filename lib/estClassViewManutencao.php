<?php
namespace lib;

require_once '../autoload.php';

class estClassViewManutencao {
    protected string $sTituloRotina;
    protected array  $aAcoes;
    protected string $sTabelaRegistrosConsulta;
    protected string $sTituloTelaInclusao;


    /**
     * Este método cria uma tabela no front end de acordo com dados recebidos.
     * 
     * @param string $sTituloTabela
     * @param array  $aColunas
     * @param array  $aDados
     * @return HTML
     */
    protected function createTable($aDados, $aAcoes) {
      $html = $this->getStyleEstrutural();

      $html .= "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse;'>";
      
      if (empty($aDados)) {
        return estClassMensagem::geraMensagemAlertaTela(estClassEnumMensagens::webbased002);
      }

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


    /**
     * Este método retorna uma tela de inclusão com os campos repassados
     * conforme mapeamento.
     * @param array $aMapaCampos
     * @return HTML
     */
    protected function getTelaInclusao($aTipagemLabel) {
       $html = "<div class='overlay'>
                <div class='container-content-inclusao'>
                    <div class ='overlayConteudo'>
                        <div class ='overlay-header'>";
                        $html .= $this->getHeaderJanela($this->getTituloTelaInclusao());
                        $html .="<aside class ='overlay-header-aside'>".estClassComponentesEstruturais::getBotaoFecharX()."</aside>";
                        $html .= "</div>";
                        $html .= $this->addLabelInclusao($aTipagemLabel);
                        $html .= $this->getFooterBotoesJanelaInclusao();
                    $html .= "</div>
                </div>
             </div>
            ";
      return $html;
    }


    /**
     * Este método adiciona campos labels conforme array repassado.
     * O array deve conter campos "type", "name" e "disabled".
     * 
     * @param array $aTipagemLabel
     * @return HTML
     */
    private function addLabelInclusao($aTipagemLabel) {
      $html = '';
      foreach ($aTipagemLabel as $sNomeLabel=>$aTipagem) {
        $html .= estClassComponentesEstruturais::getCampoLabelInclusao(
          $sNomeLabel,$aTipagem['type'], 
                      $aTipagem['name'],
                      $aTipagem['disabled']);
      }
      return $html;
    }


    /**
     * Este método retorna o footer de uma janela de inclusão
     * com botões de fechar e incluir.
     * 
     * @return HTML
     */
    private function getFooterBotoesJanelaInclusao() {
      $html = "<div class = 'overlay-footer'>
                <footer class = 'overlay-buttons'>";
         $html .= estClassComponentesEstruturais::getBotaoIncluirRegistro();
         $html .= estClassComponentesEstruturais::getBotaoFechar();
        $html .="</footer>
              </div>";
      return $html;
    }


    /**
     * Esta função retorna um header HTML com o titulo repassado no parâmetro.
     * 
     * @param string $sTituloJanela
     * @return HTML
     */
    private function getHeaderJanela($sTituloJanela) {
      return 
        "<header>
          <h2>$sTituloJanela</h2>
        </header>";
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