<?php 
namespace Controller;
use Model\User;
use Exception;

class UserController {

    private $userModel;

    public function __construct(){
        $this->userModel = new user();
}
        //REGISTRO DE USUÁRIO
        public function registerUser($user_fullname, $email, $password){
            try{
                if(empty($user_fullname) or empty($email) or empty($password)){
                    return false;
                }
                  //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                  return $this->userModel->registerUser($user_fullname, $email, $password);
            }

            catch(Exception $error){
                echo "Erro ao cadastrar o usuário" . $error->getMessage();
                return false;
            }
        }
        // E-MAIL JÁ CADASTRADO?
        public function checkUserByEmail ($email, $password) {
           return $this -> userModel->getUserByEmail($email); 
        }


        //LOGIN DE USUÁRIO
        public function login($email, $password){
            $user = $this -> userModel->getUserByEmail($email);
        /**
         * $user = [
         * "id" => 1,
         * "user_fullname" => teste,
         * "email" = "teste@example.com"
         * "password" = 9gfmnik5omkg045jmed3948u328n29083341p
         * ...
         * ]
         */

            if($user && password_verify($password, $user['password'] )){
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['user_fullname'] = $user['user_fullname'];
                    $_SESSION['email'] = $user['email'];
                    return true;
            }
            return false;
        }


        //USUÁRIO LOGADO?
        public function isloggedIn(){
            return isset ($_SESSION['id']);
        }



        //RESGATAR DADOS DO USUÁRIO
        
        public function getUserData($id, $user_fullname, $email){
            $id = $_SESSION['id'];

            return $this->userModel->getUserInfo($id, $user_fullname, $email);

        }
}

?>