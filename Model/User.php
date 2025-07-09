<?php

//CADASTRAMENTO DOS USUÁRIOS 

namespace Model;

use Model\Connection;

use PDO;
use PDOException;


class User{

    private $db;

    /**
     * MÉTODO QUE IRÁ SER EXECUTADO TODA VEZ QUE FOR CRIADO UM OBJETO DA CLASSE -> USER
     */
    //O CONSTRUCT FARÁ COM QUE AS CONEXÕES SEJAM ESTABELECIDAS TODAS AS VEZES QUE EU PRECISAR DA CLASSE USER
    public function __construct() {
        $this->db = Connection::getInstance();
    }
    
    //FUNÇÃO DE CRIAR USUÁRIO
    public function registerUser($user_fullname, $email, $password){
        try{
            //INSERÇÃO DE DADOS NA LINGUAGEM SQL - $SQL SÓ SIGNIFICA O ATO DE INSERIR AS INFORMAÇÕES 
            $sql = 'INSERT INTO  user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password, NOW())';

            //CRIPTOGRAFANDO A SENHA
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO ACIMA

            $stmt = $this->db->prepare($sql);

            //REFERENCIAR OS DADOS PASSADOS PELO COMANDO SQL COM OS PARÂMETROS DA FUNÇÃO
            //VINCULA A VARIÁVEL AO VALOR RECEBIDO, SABENDO- SE QUE ELE É DESCONHECIDO
            $stmt->bindParam(":user_fullname" , $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email" , $email, PDO::PARAM_STR);
            $stmt->bindParam( ":password", $hashedPassword,PDO::PARAM_STR);
            // EXECUTAR TUDO

            $stmt->execute();
        }

        catch(PDOException $error){
            //EXIBIR MENSAGEM DE ERRO COMPLETA COMPLETA E PARAR A EXECUÇÃO
            echo "Erro ao executar o comando" . $error->getMessage();
            return false;
        }
    }

}

?>