<?php

class QV_Produto
{

    public function consulta()
    {
        $url = "http://localhost:8000/products";

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

    public function consulta_categoria()
    {
        $url = "http://localhost:8000/product-categorys";

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

    public function consulta_produto_unica($id)
    {

        $url = "http://localhost:8000/product-only?id=" . $id;

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

        $url_categoria = "http://localhost:8000/product-categorys";

        ponto_CURL_START_CATEGORIA:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_categoria,
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
        $resposta_categoria = json_decode($body, true);

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso', 'conteudo' => $resposta, 'categoria' =>  $resposta_categoria);

        return $resultadoFinal;
    }
}
