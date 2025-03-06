<?php
namespace lib;

use lib\enum\estClassEnumMensagensWebbased;

require_once '../autoload.php';

class estClassViewManutencao {
    protected string $sTituloRotina;
    protected array  $aAcoes;
    protected string $sTabelaRegistrosConsulta;
    protected string $sTituloTelaInclusao;
    protected string $sTituloTelaAlteracao;


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
      
      
      $html .= $this->getTableHead($aDados, $aAcoes);
      
      $html .= "<tr>";
      
      $html .= $this->createColunaTable('');
      
      if (empty($aDados)) {
        $html .= $this->geraLinhaDadosTableSemRegistros();
        return $html;
      }
      
      foreach (array_keys($aDados[0]) as $chave) {     
        $html .= "<th style='background-color: #f2f2f2; padding: 8px;'>" . htmlspecialchars($chave) . "</th>";
      }
      
      $html .= "</tr>";
      

      if ($aAcoes[0]->value == 5) {
        $html .= $this->geraLinhaDadosTable($aDados, true);
      }
      else {
        $html .= $this->geraLinhaDadosTable($aDados, false);
      }
    
      $html .= "</table>";
    
      return $html;
    }


    /**
     * Este método cria as linhas com os dados para a tabela.
     * 
     * @param array $aDados
     * @param boolean $bTelaSelecionar - indica se é uma tela de selecionar registros.
     * @return HTML
     */
    private function geraLinhaDadosTable($aDados, $bTelaSelecionar) {
      $html = '';
      if ($bTelaSelecionar) {
        foreach ($aDados as $linha) {
          $html .= "<tr>";
          $html .= $this->createColunaCheckboxTelaSelecionar();
          foreach ($linha as $valor) {
              $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
          }
          $html .= "</tr>";
        }
        return $html;
      }

      foreach ($aDados as $linha) {
        $html .= "<tr>";
        $html .= $this->createColunaCheckbox();
        foreach ($linha as $valor) {
            $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= "</tr>";
      }
      return $html;
    }


    private function geraLinhaDadosTableSemRegistros() {
      $html = "<tr>";
      $html .= "<td style='padding: 8px;'>Não há registros a serem apresentados!</td>";
      $html .= "</tr>";
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
          case 5:
            $result = $result.'<button class="estButtonSelecionar" disabled>Selecionar</button>';
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
      if (empty($aDados)) {
        return 0;
      }
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
     * Este método realiza a criação de uma coluna
     * de checkbox para telas de seleção de registro.
     * 
     * @return HTML
     */
    private function createColunaCheckboxTelaSelecionar() {
      return "<td>
                <input class='estCheckboxTableSelecionar' type = 'checkbox'>
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
      $html = "<thead style='font-weight: bold; font-size: 1.2em; margin-bottom: 10px;'>
                  <tr>
                    <th colspan=".$this->getQuantidadeColunas($aDados)+1 ." style='text-align: center' id='headerTabela';>$this->sTituloRotina";
      if (empty($aAcoes)) {
        $html .= "</th> </tr> </thead>";
        return $html;
      }                    
      if ($aAcoes[0]->value === 5) {
        $html .= estClassComponentesEstruturais::getBotaoFecharX();              
      }
      $html .=      "</th>
                  </tr>
                  <tr>
                    <td colspan=".$this->getQuantidadeColunas($aDados)+1 .">
                      ". $this->getAcaoTela($aAcoes). "
                    </td>
                  </tr>
                </thead>";
      return $html;
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
     * @param array $aTipagemLabel
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
     * Este método retorna a tela de alteração de registros.
     * @param array $aTipagemLabel
     * @param array $aDados
     * @return HTML
     */
    protected function getTelaAlteracao($aTipagemLabel, $aDados) {
      $i = 0;
      foreach($aTipagemLabel as $sNomeLabel=>$aTipagem) {
        if (array_keys($aTipagemLabel)[$i] == $aDados[$i][0]) {
          $aTipagemLabel[$sNomeLabel]['value'] = $aDados[$i][1];
        }
        $i++;
      }
      $html = "<div class='overlay'>
              <div class='container-content-alteracao'>
                <div class ='overlayConteudo'>
                  <div class ='overlay-header'>";
                    $html .= $this->getHeaderJanela($this->getTituloTelaAlteracao());
                    $html .="<aside class ='overlay-header-aside'>".estClassComponentesEstruturais::getBotaoFecharX()."</aside>";
                    $html .= "</div>";
                    $html .= $this->addLabelAlteracao($aTipagemLabel);
                    $html .= $this->getFooterBotoesJanelaAlteracao();
                $html .= "</div>
            </div>
            </div>
            ";
      return $html;
    }

    /**
     * Este método adiciona campos labels conforme array repassado.
     * @param array $aTipagemLabel
     * @return HTML
     */
    private function addLabelAlteracao($aTipagemLabel) {
      $html = '';
      foreach ($aTipagemLabel as $sNomeLabel=>$aTipagem) {
        $html .= estClassComponentesEstruturais::getCampoLabelAlteracao(
          $sNomeLabel,
          $aTipagem['type'], 
          $aTipagem['name'],
          $aTipagem['disabled'],
          $aTipagem["lupa"],
          $aTipagem["required"],
          $aTipagem["value"]);
      }
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
          $sNomeLabel,
          $aTipagem['type'], 
          $aTipagem['name'],
          $aTipagem['disabled'],
          $aTipagem["lupa"],
          $aTipagem["required"]);
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
     * Este método retorna o footer de uma janela de inclusão
     * com botões de fechar e confirmar alteração.
     * 
     * @return HTML
     */
    private function getFooterBotoesJanelaAlteracao() {
      $html = "<div class = 'overlay-footer'>
                <footer class = 'overlay-buttons'>";
      $html .= estClassComponentesEstruturais::getBotaoConfirmarAlteracao();
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


    /**
     * Este método cria uma table HTML com as ações
     * e os dados repassados.
     * 
     * @param array $aDados
     * @param array $aAcoes
     */
    private function setTableConsultaView($aDados, $aAcoes) {
      $this->setTabelaRegistros($this->createTable($aDados, $aAcoes));
    }


    /**
     * Este método retorna a consulta completa, com as ações repassadas e os dados.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    protected function getConsulta($aDados, $aAcoes) {
      $this->setTableConsultaView($aDados, $aAcoes);
      return $this->sTabelaRegistrosConsulta;
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

    protected function getTituloTelaAlteracao() {
      return $this->sTituloTelaAlteracao;
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

    protected function setTituloTelaAlteracao($titulo) {
      $this->sTituloTelaAlteracao = $titulo;
    }
}

?>