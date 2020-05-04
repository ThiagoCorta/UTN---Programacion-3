<?php
class Usuario{
    public $email;
    public $clave;
    public $tipo;
    
    public function __construct($post)
    {
        $this->email = $post['email'];
        $this->clave = $post['clave'];
        $this->tipo = $post['tipo'];
    }

    public static function validateBodyReq($post){
        if(count($post) != count(array_filter($post))) return false;
        $bodyReq = ['email','clave', 'tipo'];
        foreach($bodyReq as $key=>$field){
            if(!isset($post[$field])) return false;
        }
        return true;
    }

}


?>