<?php

use \Firebase\JWT\JWT;
class Login{

    private static $key = 'pro3-parcial';
    private $user;
    public $isValidUser;


    public function __construct($email,$clave)
    {
        $file = new Files("users.dat");
        $this->user = $file->GetData($email,$clave);
        $this->isValidUser = !!isset($this->user);
    }

    public function generateToken(){
        if(!$this->isValidUser){
            echo Response::constructResponse(getStatus($this->isValidUser),getBodyRes($this->isValidUser, 'login'));
            return false;
        }
        $tokenPayload = array(
            'email' => $this->user->email,
            'clave' => $this->user->clave,
            'tipo' => $this->user->tipo,
            
        );
        return JWT::encode($tokenPayload,self::$key);
    }
    

    public static function decodeToken(){
        $headers = getallheaders();
        $token = $headers['token'] ?? '';
        $tokenDecode = '';
        if(isset($token)){
            try{
                $tokenDecode = JWT::decode($token, self::$key, array('HS256'));
            }
            catch(Exception $e){
                echo Response::constructResponse("Error", $e->getMessage());
            }
        }
        return  $tokenDecode;
    }
}
?>