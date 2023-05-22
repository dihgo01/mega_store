<?php 

class QV_MinhaConta {   

    function __construct($campos = false){
        if($campos) {
            $this->idUnidade = (isset($campos['idUnidade']) ? $campos['idUnidade'] : false);
            $this->qvemcasa_whatsapp = (isset($campos['qvemcasa_whatsapp']) ? $campos['qvemcasa_whatsapp'] : false);
            $this->qvemcasa_frase = (isset($campos['qvemcasa_frase']) ? $campos['qvemcasa_frase'] : false);
            $this->regime_tributario = (isset($campos['regime_tributario']) ? $campos['regime_tributario'] : false);
            $this->icms_situacao_tributaria = (isset($campos['icms_situacao_tributaria']) ? $campos['icms_situacao_tributaria'] : false);
            $this->icms_aliquota = (isset($campos['icms_aliquota']) ? $campos['icms_aliquota'] : false);
            $this->icms_modalidade_base_calculo = (isset($campos['icms_modalidade_base_calculo']) ? $campos['icms_modalidade_base_calculo'] : false);
            $this->senhaAtual = (isset($campos['senhaAtual']) ? $campos['senhaAtual'] : false);
            $this->senhaNova = (isset($campos['senhaNova']) ? $campos['senhaNova'] : false);
            $this->senhaNovaRepete = (isset($campos['senhaNovaRepete']) ? $campos['senhaNovaRepete'] : false);
        }
    }

    // INFORMACOES BASICAS
    public function index() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // CONTEUDO DE RETORNO
        $conteudo = [];

        // SQL SELECT - CONSULTA DADOS DO USUARIO
        $consultaUsuario = mysqli_query($conexao, 
        "SELECT * FROM users WHERE id = ".$_SESSION['Authentication']['id_usuario']." LIMIT 1 ");
        $resUsuario = mysqli_fetch_array($consultaUsuario);

        // PREENCHENDO CONTEUDO
        $conteudo['minhaConta'] = array(
            'id'                => $resUsuario['id'],
            'nome'              => $resUsuario['name'],
            'nomeExibicao'      => $resUsuario['display_name'],
            'email'             => $resUsuario['email'],
            'nascimento'        => ($resUsuario['nascimento'] ? converterData($resUsuario['nascimento'],'BR') : '-')
        );
      
        // SQL SELECT - CONSULTA PREFERENCIAS DO USUARIO
        $consultaPreferencias = mysqli_query($conexao, 
        "SELECT UP.idIdioma AS IDIOMA_ID, I.nome AS IDIOMA, UP.idFusoHorario AS FUSO_HORARIO_ID, FH.nome AS FUSO_HORARIO 
        FROM user_preferencias UP 
        INNER JOIN idiomas I ON I.idIdioma = UP.idIdioma
        INNER JOIN fusoHorario FH ON FH.idFusoHorario = UP.idFusoHorario
        WHERE UP.idUsuario = ".$_SESSION['Authentication']['id_usuario']." LIMIT 1 ");
        $resPreferencias = mysqli_fetch_array($consultaPreferencias);

        // PREENCHENDO CONTEUDO
        $conteudo['preferencias'] = array(
            'id_idioma'         => $resPreferencias['IDIOMA_ID'],
            'idioma'            => $resPreferencias['IDIOMA'],
            'id_fuso_horario'   => $resPreferencias['FUSO_HORARIO_ID'],
            'fuso_horario'      => $resPreferencias['FUSO_HORARIO']
        );    
        
        // VALIDACAO FINAL                 
        if($consultaUsuario && $consultaPreferencias) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$conteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }

    // HISTORICO DE LOGIN
    public function historicoLogin() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // CONTEUDO DE RETORNO
        $conteudo = [];

        // SQL SELECT - CONSULTA DADOS DE LOGIN DO USUARIO
        $consulta = mysqli_query($conexao, 
        "SELECT * FROM user_logins WHERE idUsuario = ".$_SESSION['Authentication']['id_usuario']." AND status = 'Ativo' ORDER BY dataInsert DESC LIMIT 10 ");
        $conteudo['resultados'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {

            // PREENCHENDO CONTEUDO
            $conteudo['itens'][] = array(
                'user_agent'        => $resultado['user_agent'],
                'ip'                => $resultado['ip'],
                'horario'           => converterData($resultado['dataInsert'],'COMPLETA')
            );

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$conteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    } 
    
    // LISTAGEM DE FRANQUIAS
    public function franquiasList() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // CONTEUDO DE RETORNO
        $conteudo = [];

        // SQL SELECT - CONSULTA FRANQUIAS DO USUARIO
        $consulta = mysqli_query($conexao, 
        "SELECT F.slug AS SLUG, F.id AS UNIDADE_ID, F.nome_exibicao AS NOME, F.nome_fantasia AS NOME_FANTASIA, F.razao_social AS RAZAO_SOCIAL, F.cnpj AS CNPJ, F.show_whatsapp AS QVEMCASA_WHATSAPP, F.qvemcasa_fraseDestaque AS QVEMCASA_FRASE_DESTAQUE 
        FROM qv_franquias F
        INNER JOIN has_usuarios_unidades HUU ON HUU.idUnidade = F.id
        WHERE HUU.idUsuario = ".$_SESSION['Authentication']['id_usuario']." AND HUU.status = 'Ativo'");
        $conteudo['resultados'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {

            // PREENCHENDO CONTEUDO
            $conteudo['itens'][] = array(
                'slug'              => $resultado['SLUG'],
                'unidade_id'        => $resultado['UNIDADE_ID'],
                'nome'              => $resultado['NOME'],
                'razao_social'      => $resultado['RAZAO_SOCIAL'],
                'nome_fantasia'     => $resultado['NOME_FANTASIA'],
                'cnpj'              => maskPHP(limpar($resultado['CNPJ']),'##.###.###/####-##'),
                'qvemcasa_whatsapp' => $resultado['QVEMCASA_WHATSAPP'],
                'qvemcasa_frase_destaque' => $resultado['QVEMCASA_FRASE_DESTAQUE']
            );

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$conteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }    
    
    // UPDATE FRANQUIAS > QVEMCASA
    public function franquiasQVEmCasa() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $QV_idUnidade           = $this->idUnidade;
        $QV_qvemcasa_whatsapp   = $this->qvemcasa_whatsapp;
        $QV_qvemcasa_frase      = $this->qvemcasa_frase;

        // SQL UPDATE - ATUALIZA UNIDADE
        $atualizar = mysqli_query($conexao, 
        "UPDATE qv_franquias SET show_whatsapp = '".$QV_qvemcasa_whatsapp."', qvemcasa_fraseDestaque = '".$QV_qvemcasa_frase."' WHERE id = ".$QV_idUnidade." ");

        // VALIDACAO FINAL                 
        if($atualizar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Operação Realizada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }  
    
    // DADOS FISCAIS DAS FRANQUIAS DO USUARIO - LIST
    public function franquiasConfigFiscaisList() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // CONTEUDO DE RETORNO
        $conteudo = [];

        // SQL SELECT - CONSULTA FRANQUIAS DO USUARIO
        $consulta = mysqli_query($conexao, 
        "SELECT F.id AS UNIDADE_ID, DF.regime_tributario AS REGIME_TRIBUTARIO, DF.icms_situacao_tributaria AS ICMS_SITUACAO_TRIBUTARIA, DF.icms_aliquota AS ICMS_ALIQUOTA, DF.icms_modalidade_base_calculo AS ICMS_MODALIDADE_BASE_CALCULO
        FROM qv_franquias F
        INNER JOIN has_usuarios_unidades HUU ON HUU.idUnidade = F.id
        INNER JOIN PDV_unidadesDadosFiscais DF ON DF.idUnidade = F.id
        WHERE HUU.idUsuario = ".$_SESSION['Authentication']['id_usuario']." AND HUU.status = 'Ativo' AND DF.status = 'Ativo' ");
        $conteudo['resultados'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {

            // PREENCHENDO CONTEUDO
            $conteudo['itens'][] = array(
                'unidade_id'                    => $resultado['UNIDADE_ID'],
                'regime_tributario'             => $resultado['REGIME_TRIBUTARIO'],
                'icms_situacao_tributaria'      => $resultado['ICMS_SITUACAO_TRIBUTARIA'],
                'icms_aliquota'                 => $resultado['ICMS_ALIQUOTA'],
                'icms_modalidade_base_calculo'  => $resultado['ICMS_MODALIDADE_BASE_CALCULO']
            );

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$conteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }   
    
    // UPDATE FRANQUIAS > DADOS FISCAIS
    public function franquiasConfigFiscaisUpdate() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $QV_idUnidade                   = $this->idUnidade;
        $QV_regime_tributario           = $this->regime_tributario;
        $QV_icms_situacao_tributaria    = $this->icms_situacao_tributaria;
        $QV_icms_aliquota               = (!empty($this->icms_aliquota) ? str_replace(',', '.',$this->icms_aliquota) : 0);
        $QV_icms_modalidade_base_calculo= $this->icms_modalidade_base_calculo;

        // CHECK EXISTE CONFIGS FISCAIS DA UNIDADE
        $consulta = mysqli_query($conexao,"SELECT * FROM PDV_unidadesDadosFiscais WHERE idUnidade = ".$QV_idUnidade." ");
        if(mysqli_num_rows($consulta) == 0) {
            // SQL INSERT - CONFIGS FISCAIS DA UNIDADE
            $adicionar = mysqli_query($conexao, "INSERT INTO PDV_unidadesDadosFiscais (idUnidade, dataInsert) VALUES ('".$QV_idUnidade."', NOW())");  
        }

        // SQL UPDATE - ATUALIZA CONFIGS FISCAIS
        $atualizar = mysqli_query($conexao, 
        "UPDATE PDV_unidadesDadosFiscais SET regime_tributario = '".$QV_regime_tributario."', icms_situacao_tributaria = '".$QV_icms_situacao_tributaria."', icms_aliquota = '".$QV_icms_aliquota."', icms_modalidade_base_calculo = '".$QV_icms_modalidade_base_calculo."' WHERE idUnidade = ".$QV_idUnidade." ");

        // VALIDACAO FINAL                 
        if($atualizar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Operação Realizada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Falha na Requisição. Contate o Suporte!', 'a'=> $QV_icms_aliquota);
        }        

        // RETORNO
        return $resultadoFinal;

    }  

    // UPDATE SEGURANCA > SENHA
    public function alterarSenha() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $QV_senhaAtual          = $this->senhaAtual;
        $QV_senhaNova           = $this->senhaNova;
        $QV_senhaNovaRepete    = $this->senhaNovaRepete;

        // VALIDACAO FINAL
        $checkFinal = false;
        $mensagemErro = "";

        // SQL SELECT - CONSULTA USUARIO
        $consulta = mysqli_query($conexao,"SELECT * FROM users WHERE id = ".$_SESSION['Authentication']['id_usuario']." ");
        if(mysqli_num_rows($consulta) == 0) {
            $mensagemErro = "Não foi possível encontrar o usuário.";
        } else {
            
            $resultado = mysqli_fetch_array($consulta);

            // VALIDA SENHA ATUAL
            if(B_CRYPT("validar", $QV_senhaAtual, $resultado['password'])) {

                // VALIDA SE NOVA SENHA BATE
                if($QV_senhaNova == $QV_senhaNovaRepete) {

                    // CRIPTOGRAFA NOVA SENHA
                    $senhaNova = B_CRYPT("gerar", $QV_senhaNova);

                    // SQL UPDATE - ATUALIZAR SENHA DO USUARIO
                    $atualizar = mysqli_query($conexao, 
                    "UPDATE users SET password = '".$senhaNova."' WHERE id = ".$_SESSION['Authentication']['id_usuario']." ");

                    // CHECK FINAL
                    if($atualizar) {
                        $checkFinal = true;
                    } else {
                        $mensagemErro = "Erro ao Alterar Senha. Contate o Suporte.";
                    }

                } else {
                    $mensagemErro = "Senha nova não confere.";
                }

            } else {
                $mensagemErro = "Senha atual não confere.";
            }

        }

        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Operação Realizada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    }     
    
    
}
?>