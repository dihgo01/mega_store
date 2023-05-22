<?php 
/******************************************************************************/
/****************************** NOVIDADES *************************************/
/******************************************************************************/
class QV_Novidades {

    function __construct($slug = false){
        $this->slug = $slug;
    }     

    //***** CONSULTA DE NOVIDADES
    public function index() {

        // BANCO DADOS
        $conexaoIntranetAntiga = bancoDados("conectar","intranet");

        // ARMAZENA e CONTROLA os RESULTADOS
        $html_final     = "";
        $periodo_atual  = "";
        $mes_atual      = "";
        $contador_loop  = 0;
        
        // SQL - SELECT
        $consulta = mysqli_query($conexaoIntranetAntiga, "SELECT conteudo AS CONTEUDO, DATE(dataInsert) AS DATA_CRIACAO, CONCAT(YEAR(dataInsert),'/',MONTH(dataInsert)) AS PERIODO, MONTH(dataInsert) AS MES, YEAR(dataInsert) AS ANO, tipo AS TIPO FROM PDV_novidades WHERE status = 'Ativo' ORDER BY dataInsert DESC");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {

            // FECHO CARD
            if($periodo_atual != $resultado['PERIODO'] && !empty($periodo_atual) ) {
                $html_final .= '</div></div> <!-- FECHANDO CARD -->'; 
            }

            // ABRO CARD CHECANDO PERIODO
            if($periodo_atual != $resultado['PERIODO']) {

                $mes_atual = nomeMes($resultado['MES'])."/".$resultado['ANO'];

                $html_final .= '
                    <div class="card mb-3">
                        <div class="card-header"><h5 class="mb-0">'.$mes_atual.'</h5></div>
                        <div class="card-body">
                ';        

            } 

            // CONTEUDO
            $html_final .= '<p><i class="fas fa-caret-right"></i> '.$resultado['CONTEUDO'].' - <span class="small text-muted">'.converterData($resultado['DATA_CRIACAO'],'BR').'</span></p>';

            // INFORMO O PERIODO ATUAL
            $periodo_atual = $resultado['PERIODO']; 

            // ATUALIZAR CONTADOR 
            $contador_loop++;

            // FECHO CARD
            if($contador_loop == $resConteudo['RESULTADOS']) {
                $html_final .= '</div></div> <!-- FECHANDO CARD -->'; 
            }    

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$html_final);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!', 'erro'=>$erro);
        }        

        // RETORNO
        return $resultadoFinal;        

    }
    
}
?>