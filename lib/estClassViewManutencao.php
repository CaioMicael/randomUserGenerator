<?php


class estClassViewManutencao {
    private $html;

    public function createTable($sTituloTabela, $aColunas, $aDados) {
        if (empty($aDados) || empty($aColunas)) {
            return "<p><strong>Nenhum dado disponível para exibição.</strong></p>";
        }
    
        $html = "<table border='1' cellspacing='0' cellpadding='5'>";
        $html .= "<caption><strong>$sTituloTabela</strong></caption>";
    
        // Cabeçalho da tabela
        $html .= "<tr>";
        foreach ($aColunas as $campo => $rotulo) {
            $html .= "<th>$rotulo</th>";
        }
        $html .= "</tr>";
    
        // Dados da tabela
        foreach ($aDados as $linha) {
            $html .= "<tr>";
            foreach ($aColunas as $campo => $rotulo) {
                $html .= "<td>" . (isset($linha[$campo]) ? htmlspecialchars($linha[$campo]) : '') . "</td>";
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