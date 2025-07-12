<?php

namespace controller;
use Model\Imcs;
use Exception;

class ImcController
{
    private $imcsModel;

    public function __construct()
    {
        $this->imcsModel = new Imcs();
    }

    //CÁLCULO E CLASSIFICAÇÃO DO IMC
    public function calculateImc($weight, $height)
    {
        try {
            $result = [];
            if (isset($weight) or isset($height)) {
                if ($weight > 0 and $height > 0) {
                
                    $imc = round($weight / ($height * $height), 2);
                     // O ARRAY RESULT VAI ARMAZENAR O CÁLCULO QUE VARIÁVEL ACIMA ESTÁ FAZENDO 
                    $result['imc'] = $imc;

                    $result["BMIrange"] = match (true){
                        $imc < 18.5 => "Baixo peso",
                        $imc >= 18.5 and $imc < 25 => "Peso normal",
                        $imc >= 25 and $imc < 30 => "Sobrepeso",
                        $imc >= 30 and $imc < 35 => "Obesidade grau I",
                        $imc >= 35 and $imc < 40 => "Obesidade grau II",  
                        default => "Obesidade grau III"                  
                    };
                } else {
                     $result["BMIrange"] = "O peso e a altura devem conter valores positivos";
                }

            } else {
                $result["BMIrange"] = "Por favor, informe peso e altura para obter o seu IMC";
            }

            return $result;

        } catch (Exception $error) {
            echo "Erro ao calcular IMC: " . $error->getMessage();
            return false;
        }
    }
    //PEGAR PESO ALTURA E RESULTADO DO FRONT E ENVIAR PARA O BANCO DE DADOS
    //SALVAR IMC NA TABElA 'imcs'
    public function saveIMC($weight, $height, $IMCresult){
        return $this->imcsModel->createImc($weight, $height, $IMCresult);
    }
}

?>