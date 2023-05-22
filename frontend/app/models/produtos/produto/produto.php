<?php

class QV_Produto
{
    private $slug;

    function __construct($slug = false)
    {
        $this->slug = $slug;
    }

    //***** CONSULTA DE DADOS DO PRODUTO
    public function consulta()
    {

        $url = "http://localhost:8000/products";

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
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta = json_decode($body, true);

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resposta);

        return $resultadoFinal;
    }

    //***** CONSULTA DE DADOS DO IMPOSTO
    public function consulta_imposto()
    {

        $url = "http://localhost:8000/taxs";

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

    //***** CONSULTA DE CATEGORIA UNICA
    public function consulta_categoria_unica($id)
    {

        $url = "http://localhost:8000/product-category-only?id=" . $id;


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
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta = json_decode($body, true);

        $url_imposto = "http://localhost:8000/taxs";

        // CURL - START
        ponto_CURL_START_IMPOSTO:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_imposto,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta_imposto = json_decode($body, true);

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resposta, 'imposto' => $resposta_imposto);

        // RETORNO
        return $resultadoFinal;
    }
}
