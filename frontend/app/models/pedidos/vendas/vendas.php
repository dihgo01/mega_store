<?php

/******************************************************************************/
/****************************** PRODUTOS **************************************/
/******************************************************************************/
class QV_Produtos
{
    private $slug;
    
    function __construct($slug = false)
    {
        $this->slug = $slug;
    }

    //***** CONSULTA DE CATEGORIAS
    public function categorias()
    {

        // BANCO DADOS
        $conexao = bancoDados("conectar", "intranet");

        // LIMITAR CATEGORIAS
        $CAT_NOT_SHOW = array(13, 14, 24, 25, 26, 28, 29);

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "SELECT * FROM qv_categorias WHERE id NOT IN(" . implode(',', $CAT_NOT_SHOW) . ") AND deleted_at IS NULL ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        while ($resultado = mysqli_fetch_array($consulta)) {
            $resConteudo['ITENS'][] = array('ID' => $resultado['id'], 'NOME' => $resultado['nome']);
        }

        // VALIDACAO FINAL                 
        if ($consulta) {
            $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado' => false, 'mensagem' => 'Erro ao Realizar Consulta. Contate o Suporte!');
        }

        // RETORNO
        return $resultadoFinal;
    }

    //***** CONSULTA DE DADOS DO PRODUTO
    public function consulta()
    {

        // VARIAVEIS
        $slug = $this->slug;

        $url = "http://localhost:8000/product-categorys";

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODQ3MzgwMzcsImlhdCI6MTY4NDcyODAzNywiaWQiOiJjMWE0MWYwNzllMGQzN2U4MjgyOGEyYmE2YzdjNTUwMSJ9.yZaWKMTHQW7pARbD0598FI324sAEQs4rjLrM45FwBgg';

        // CURL - START
        ponto_CURL_START:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta = json_decode($body, true);
        //var_dump($body);
        $array = array();
        foreach ($resposta as $item) {
            //var_dump($item);
            $array['ITENS'] = [
                "id" => $item['id'],
                "category" => $item['category'],
                "tax" => $item['tax'],
            ];
        }
        //var_dump($array);

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resposta);


        // RETORNO
        return $resultadoFinal;
    }
}

/******************************************************************************/
/****************** VENDAS | CREATE / UPDATE / REPORTS ************************/
/******************************************************************************/
class QV_Vendas
{
    private $slug;
    function __construct($slug = false)
    {
        $this->slug = $slug;
    }

    
    //***** CONSULTA DADOS DA VENDA
    public function consultaVenda()
    {

        $url = "http://localhost:8000/sales";

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODQ3MzgwMzcsImlhdCI6MTY4NDcyODAzNywiaWQiOiJjMWE0MWYwNzllMGQzN2U4MjgyOGEyYmE2YzdjNTUwMSJ9.yZaWKMTHQW7pARbD0598FI324sAEQs4rjLrM45FwBgg';

        // CURL - START
        ponto_CURL_START:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta = json_decode($body, true);

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resposta);

        // RETORNO
        return $resultadoFinal;
    }
 
}
