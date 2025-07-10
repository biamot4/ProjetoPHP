<?php

//CADASTRAMENTO DOS USUÁRIOS 

namespace Model;

use Model\Connection;

use PDO;
use PDOException;


class User
{

    private $db;

    /**
     * MÉTODO QUE IRÁ SER EXECUTADO TODA VEZ QUE FOR CRIADO UM OBJETO DA CLASSE -> USER
     */
    //O CONSTRUCT FARÁ COM QUE AS CONEXÕES SEJAM ESTABELECIDAS TODAS AS VEZES QUE EU PRECISAR DA CLASSE USER
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    //FUNÇÃO DE CRIAR USUÁRIO
    public function registerUser($user_fullname, $email, $password)
    {
        try {
            //INSERÇÃO DE DADOS NA LINGUAGEM SQL - $SQL SÓ SIGNIFICA O ATO DE INSERIR AS INFORMAÇÕES 
            $sql = 'INSERT INTO  user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password, NOW())';

            //CRIPTOGRAFANDO A SENHA
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO ACIMA
            $stmt = $this->db->prepare($sql);

            //REFERENCIAR OS DADOS PASSADOS PELO COMANDO SQL COM OS PARÂMETROS DA FUNÇÃO
            //VINCULA A VARIÁVEL AO VALOR RECEBIDO, SABENDO- SE QUE ELE É DESCONHECIDO
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
           
            // EXECUTAR TUDO
            $stmt->execute();

        } catch (PDOException $error) {
            //EXIBIR MENSAGEM DE ERRO COMPLETA COMPLETA E PARAR A EXECUÇÃO
            echo "Erro ao executar o comando" . $error->getMessage();
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {}
    }

    public function getUserInfo($id, $user_fullname, $email)
    {
        try {
            // " : " É PARA RECEBER AS INFORMAÇÕES SEM ESCREVÊ-LAS DIRETAMENTE NO CÓDIGO (PROTEÇÃO). A INFORMAÇÃO 
            // É DESCONHECIDA E SOMENTE SERÁ RECEBIDA ATRAVÉS DA FUNÇÃO E CONSIDERADA NA DEVIDA POSIÇÃO

            $sql = "SELECT user_fullname, email FROM user WHERE id= :id AND user_fullname= :user_fullname AND email = :email";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id" , $id, PDO::PARAM_INT);
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR); 
            $stmt->execute();

            /**
             * fetch = querySelector
             * FetchAll = querySelectorAll
             * 
             * FETCH_ASSOC:
             * $user[
             * "user_fullname" => "teste",
             * "email" => "teste@exemple.com"
             * ]
             * 
             * COMO OBTER INFORMAÇÕES: 
             * $user['user_fullname'];
             */

             
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) { 
            echo "Erro ao buscar informações: " , $error->getMessage();
            return false; 
        }
    }

}

?>