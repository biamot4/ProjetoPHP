<?php
//ESTABELECIMENTO DA CONEXÃO COM O BANCO DE DADOS 



//CONFIGURAÇÕES DE USO

//EXEMPLO DE USO EM OUTRAS CLASSES = use Model/Connection
namespace Model;

//IMPORTAÇÃO PARA A CONEXÃO COM BANCO DE DADOS
use PDO;
use PDOException;


//BUSCANDO DADOS DE CONFIGURAÇÃO DO BANCO DE DADOS 
require_once __DIR__ ."/../Config/configuration.php";

class Connection {
    //ATRIBUTO ESTÁTICO QUE IRÁ PERMITIR A CONEXÃO ABAIXO 
   private static $stmt;

    //CONEXÃO COM BANCO DE DADOS
    public static function getInstance() {
        //CRIA UMA NOVA CONEXÃO SOMENTE SE ELA NÃO EXISTIR 
        
        try {
            if(empty(self:: $stmt)){
            //ELE SIMBOLIZA O STATUS DA CONEXÃO 

            self::$stmt = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . '' , DB_USER, DB_PASSWORD);
        }
        }catch(PDOException $error){
            die(" Erro ao estabelecer conexão: " . $error->getMessage());
        }
        return self::$stmt;
    }
}

?>