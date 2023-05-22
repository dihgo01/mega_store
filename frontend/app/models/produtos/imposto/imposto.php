<?php

class QV_Imposto
{
    private $slug;

    function __construct($slug = false)
    {
        $this->slug = $slug;
    }

    //***** CONSULTA DE DADOS DO IMPOSTO
    public function consulta()
    {

        $url = "http://localhost:8000/taxs";

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

        // RETORNO
        return $resultadoFinal;
    }

    //***** CONSULTA DE IMPOSTO UNICA
    public function consulta_unica($id)
    {
        $url = "http://localhost:8000/tax-only?id=" . $id;

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

        // RETORNO
        return $resultadoFinal;
    }

}
