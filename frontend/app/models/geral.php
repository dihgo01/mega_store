<?php 
/******************************************************************************/
/******************************** GERAL ************************************/
/******************************************************************************/
class QV_Geral {

    function __construct($campos = false){
        if($campos) {
            $this->campos = (isset($campos) ? $campos : false); 
        }
    }

    //***** TROCAR MODULO | ALTERA MENU SIDEBAR
    public function trocarModulo() {  

        // VARIAVEIS RECEBIDAS
        $campos = $this->campos;          

        // ATUALIZA VARIAVEL GLOBAL COM DADOS DO USUARIO
        if($_SESSION['Authentication']) {
            $_SESSION['Authentication']['sidebar'] = $campos['modulo'];
            $checkFinal = true; 
        } else {
            $checkFinal = false;
        }
          
        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Operação Realizada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro na Operação. Contate o Suporte!');
        }

        // RETORNO
        return $resultadoFinal;          
        
    }    
    
}

/******************************************************************************/
/******************************** UNIDADES ************************************/
/******************************************************************************/
class QV_Unidades {

    function __construct($campos){
        if($campos) {
            $this->termo     = (isset($campos['termo']) ? $campos['termo'] : false);
            $this->idUnidade = (isset($campos['idUnidade']) ? $campos['idUnidade'] : false);
        }
    }     

    //***** CONSULTANDO UNIDADES
    public function consulta() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_termo = $this->termo;

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // MONTANDO QUERY DE USUARIO PARA FILTRAGEM
        if($_SESSION['Authentication']['nivel'] == 1 || $_SESSION['Authentication']['nivel'] == 5) {
            $queryUsuario = "";
        } else {
            $queryUsuario = " AND F.user_id = '".$_SESSION['Authentication']['id_usuario']."' ";
        }        

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "
            SELECT F.id AS ID_UNIDADE, F.slug AS SLUG, F.nome_exibicao AS NOME, F.email AS EMAIL, F.telefone1 AS TELEFONE, F.instagram1 AS INSTAGRAM, F.cnpj AS CNPJ, F.razao_social AS RAZAO_SOCIAL, M.id AS ID_FOTO, M.file_name AS ARQUIVO 
            FROM qv_franquias F
            INNER JOIN users U ON U.id = F.usuario_id
            LEFT JOIN media M ON M.model_id = U.id AND M.collection_name = 'avatar'
            WHERE F.nome LIKE '%".$QV_termo."%' OR F.razao_social LIKE '%".$QV_termo."%' ".$queryUsuario." AND F.deleted_at IS NULL ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {

            // CHECANDO FOTO PERFIL
            if(!empty($resultado['ID_FOTO'])) {
                $fotoPerfil = 'https://franquia.quintavalentina.com.br/assets/media/'.$resultado['ID_FOTO'].'/'.$resultado['ARQUIVO'];
            } else {
                $fotoPerfil = '/assets/images/no-photo.jpeg';
            }            

            // MONTANDO ARRAY DE RESULTADOS
            $resConteudo['ITENS'][] = array('id'            => $resultado['ID_UNIDADE'], 
                                            'slug'          => $resultado['SLUG'],
                                            'nome'          => $resultado['NOME'],
                                            'email'         => $resultado['EMAIL'],
                                            'telefone'      => limpar($resultado['TELEFONE']),
                                            'instagram'     => $resultado['INSTAGRAM'],
                                            'cnpj'          => limpar($resultado['CNPJ']),
                                            'razao_social'  => $resultado['RAZAO_SOCIAL'],
                                            'foto'          => $fotoPerfil
                                        );

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!', 'erro'=>$erro);
        }

        // RETORNO
        return $resultadoFinal;        

    } 

    //***** DEFINIR NOVA UNIDADE
    public function definirUnidade() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_idUnidade = $this->idUnidade;

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // MONTANDO QUERY DE USUARIO PARA FILTRAGEM
        if($_SESSION['Authentication']['nivel'] == 1 || $_SESSION['Authentication']['nivel'] == 5) {
            $queryUsuario = "";
        } else {
            $queryUsuario = " AND F.user_id = '".$_SESSION['Authentication']['id_usuario']."' ";
        }

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "
            SELECT F.id AS UNIDADE, F.slug AS SLUG, F.nome_exibicao AS UNIDADE_NOME, F.slug AS SLUG, F.NF_token AS NF_TOKEN, F.tipoFranquia AS TIPO_FRANQUIA
            FROM qv_franquias F
            WHERE F.id = '".$QV_idUnidade."' ".$queryUsuario." AND F.deleted_at IS NULL LIMIT 1");

        // SE ID FOI ENCONTRADO
        if(mysqli_num_rows($consulta) > 0 && $_SESSION['Authentication']) {

            $resultado = mysqli_fetch_array($consulta);

            if($_SESSION['Authentication']['nivel'] == 1 || $_SESSION['Authentication']['nivel'] == 5) {

                // ATUALIZA VARIAVEL GLOBAL COM DADOS DO USUARIO
                $_SESSION['Authentication']['franquias'][0]['unidade'] = $resultado['UNIDADE'];
                $_SESSION['Authentication']['franquias'][0]['unidade_nome'] = $resultado['UNIDADE_NOME']; 
                $_SESSION['Authentication']['franquias'][0]['slug'] = $resultado['SLUG'];
                $_SESSION['Authentication']['franquias'][0]['tipo_franquia'] = $resultado['TIPO_FRANQUIA'];
                $_SESSION['Authentication']['franquias'][0]['emissaoFiscal'] = (!empty($resultado['NF_TOKEN']) ? true : false);
                $_SESSION['Authentication']['franquiaActive'] = 0;


            } else {

                $franquiaAtiva = array_search($resultado['UNIDADE'], array_column($_SESSION['Authentication']['franquias'], 'unidade'));

                if($franquiaAtiva) {
                    $_SESSION['Authentication']['franquiaActive'] = $franquiaAtiva;
                } else {
                    $consulta = false;
                }
                
            }

        } else {
            $consulta = false;
        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Troca de Unidade Realizada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Troca de Unidade. Contate o Suporte!');
        }

        // RETORNO
        return $resultadoFinal;          
        
    }

    //***** RESTAURAR UNIDADE NEUTRA
    public function unidadeNeutra() {  

        // ATUALIZA VARIAVEL GLOBAL COM DADOS DO USUARIO
        if($_SESSION['Authentication']) {
            $_SESSION['Authentication']['franquias'][0]['unidade'] = 0;
            $_SESSION['Authentication']['franquias'][0]['unidade_nome'] = "NEUTRA"; 
            $_SESSION['Authentication']['franquias'][0]['slug'] = 'neutra';
            $_SESSION['Authentication']['franquias'][0]['tipo_franquia'] = 'Home';
            $_SESSION['Authentication']['franquias'][0]['emissaoFiscal'] = false;
            $_SESSION['Authentication']['franquiaActive'] = 0;
            $checkFinal = true; 
        } else {
            $checkFinal = false;
        }
          
        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Unidade Neutra Ativada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Ativar Unidade Neutra. Contate o Suporte!');
        }

        // RETORNO
        return $resultadoFinal;          
        
    }    
    
}
?>