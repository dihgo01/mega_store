<?php 

class QV_Login {

    function __construct($campos){
        if($campos) {
            $this->login    = (isset($campos['login']) ? $campos['login'] : false);
            $this->senha    = (isset($campos['senha']) ? $campos['senha'] : false);
        }
    }     

    //***** VALIDANDO LOGIN
    public function index() {  

        // VALIDA RECEBIMENTO
        if(!empty($QV_login) && !empty($QV_senha)) {

            // SQL - SELECT
            
            
            // CHECA SE ALGUM USUARIO FOI ENCONTRADO COM LOGIN INFORMADO
            if(mysqli_num_rows($consulta) == 0) {

                $_SESSION['Authentication']['loginStatus'] = false; 
                $MENSAGEM_ERRO = "O Login é Inválido ou não Existe.";		

            } else {

                // RECEBE DADOS DO USUARIO QUE ESTA FAZENDO LOGIN
                $resultado = mysqli_fetch_array($consulta);	

                // VERIFICA SE EH LOGIN ESPECIAL
                if($QV_logginChave) {
                    $_SESSION['Authentication']['loginStatus'] = true;
                } else {

                    // Senha já criptografada (salva no banco)
                    $hash = $resultado['SENHA'];

                    // CHECA SENHA
                    if(crypt($nsenha, $hash) === $hash) {
                        $_SESSION['Authentication']['loginStatus'] = true;
                    } else {
                        $_SESSION['Authentication']['loginStatus'] = false;			
                        $MENSAGEM_ERRO = "A Senha é Inválida.";
                    }	

                }

            }

            // TRATANDO DADOS DO LOGIN
            if($_SESSION['Authentication']['loginStatus'] == true) {

                // LISTA DE FRANQUIAS
                $listaFranquia = array();

                // VALIDA NIVEL
                if(in_array($resultado['ID_USUARIO'],$consultoresLista)) {

                    $resultado['NIVEL']         = 'Operações'; 
                    $resultado['NIVEL_ID']      = 5; // Operações
                    $resultado['UNIDADE']       = 0;
                    $resultado['UNIDADE_NOME']  = "NEUTRA";
                    $resultado['TIPO_FRANQUIA'] = "Home";
                    $resultado['SIDEBAR']       = "fms";

                    // ALIMENTA ARRAY DE FRANQUIAS
                    $listaFranquia[] = array(
                        'unidade'       => $resultado['UNIDADE'],
                        'unidade_nome'  => $resultado['UNIDADE_NOME'],
                        'tipo_franquia' => $resultado['TIPO_FRANQUIA'],
                        'slug'          => "neutra",
                        'emissaoFiscal' => false
                    );                   

                } elseif(in_array($resultado['ID_USUARIO'],$adminsLista)) {

                    $resultado['NIVEL']         = 'root'; // ROOT
                    $resultado['NIVEL_ID']      = 1; // ROOT
                    $resultado['UNIDADE']       = 0;
                    $resultado['UNIDADE_NOME']  = "NEUTRA";
                    $resultado['TIPO_FRANQUIA'] = "Home";
                    $resultado['SIDEBAR']       = "ims";	
                    
                    // ALIMENTA ARRAY DE FRANQUIAS
                    $listaFranquia[] = array(
                        'unidade'       => $resultado['UNIDADE'],
                        'unidade_nome'  => $resultado['UNIDADE_NOME'],
                        'tipo_franquia' => $resultado['TIPO_FRANQUIA'],
                        'slug'          => "neutra",
                        'emissaoFiscal' => false
                    ); 

                } else {

                    $resultado['NIVEL']     = 'franquia'; // FRANQUIA
                    $resultado['NIVEL_ID']  = 12; // FRANQUEADA HOME 
                    $resultado['SIDEBAR']   = "fms";                   

                    // BUSCANDO FRANQUIAS DO USUARIO
                    $buscandoFranquias = mysqli_query($conexao, "SELECT
                        F.id AS UNIDADE,
                        F.nome_exibicao AS UNIDADE_NOME,
                        F.tipoFranquia AS TIPO_FRANQUIA,
                        F.slug AS SLUG,
                        F.NF_token AS NF_TOKEN
                        FROM qv_franquias F
                        WHERE F.usuario_id = ".$resultado['ID_USUARIO']." AND F.deleted_at IS NULL ORDER BY F.id ASC");
                    if(mysqli_num_rows($buscandoFranquias) == 0) {

                        // ALIMENTA ARRAY DE FRANQUIAS
                        $listaFranquia[] = array(
                            'unidade'       => 0,
                            'unidade_nome'  => "NEUTRA",
                            'tipo_franquia' => "Home",
                            'slug'          => "neutra",
                            'emissaoFiscal' => false
                        );                   

                    } else {

                        WHILE($resFranquias = mysqli_fetch_array($buscandoFranquias)) {

                            // ALIMENTA ARRAY DE FRANQUIAS
                            $listaFranquia[] = array(
                                'unidade'       => $resFranquias['UNIDADE'],
                                'unidade_nome'  => $resFranquias['UNIDADE_NOME'],
                                'tipo_franquia' => $resFranquias['TIPO_FRANQUIA'],
                                'slug'          => $resFranquias['SLUG'],
                                'emissaoFiscal' => (!empty($resFranquias['NF_TOKEN']) ? true : false)
                            );                             

                        }

                    }

                }
                // VALIDA NIVEL
                
                // TRATANDO INICIAIS
                $iniciaisTemp = explode(" ",$resultado['NOME']);
                $iniciais = mb_strimwidth($iniciaisTemp[0],0,1).mb_strimwidth(end($iniciaisTemp),0,1);

                // ATUALIZA VARIAVEL GLOBAL COM DADOS DO USUARIO
                $_SESSION['Authentication'] = [
                    'status'          => true,
                    'id_usuario'      => $resultado['ID_USUARIO'],
                    'nome'            => $resultado['NOME'],
                    'nome_completo'   => $resultado['NOME_COMPLETO'],
                    'iniciais'        => $iniciais,
                    'login'           => $resultado['LOGIN'],
                    'email'           => $resultado['EMAIL'],
                    'nascimento'      => ($resultado['NASCIMENTO'] ? converterData($resultado['NASCIMENTO'],'BR') : '-'),
                    'nivel'           => $resultado['NIVEL_ID'],
                    'sidebar'         => $resultado['SIDEBAR'],
                    'franquias'       => $listaFranquia,
                    'franquiaActive'  => 0,
                    'data_criacao'    => converterData($resultado['DATA_CRIACAO'],'BR'),
                    'escopo'          => $resultado['NIVEL'],
                    'validaSempre'    => true
                ];

                // COOKIES
                $session_name = "QV_VITRINE";
                setcookie($session_name,session_id(),time()+2*7*24*60*60);

                // Verifica a opção se sempre validar o login
                if($_SESSION['Authentication']['validaSempre'] == true) {
                    $_SESSION['usuarioLogin'] = $nusuario;
                    $_SESSION['usuarioSenha'] = $nsenha;
                }		
                
                $MENSAGEM_ERRO = "";

                // LOGIN SUCESSO
                $checkFinal = true;     

            } else {
                $checkFinal = false;
                $MENSAGEM_ERRO = "Credenciais de Login Inválidas.";	
            }

        } else {
            $checkFinal = false;
            $MENSAGEM_ERRO = "Formulário não foi enviado corretamente.";	
        }

        // VALIDACAO FINAL                 
        if($checkFinal) {

            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Login Realizado com Sucesso', 'conteudo'=> $_SESSION['Authentication']);

            unset($_SESSION['loginMensagemErro']);

        } else {

            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $MENSAGEM_ERRO, 'debug' => $SQL_ERROR_MESSAGEM);

            $_SESSION['loginMensagemErro'] = $MENSAGEM_ERRO;

        }        

        // RETORNO
        return $resultadoFinal;        

    } 
    
}
?>