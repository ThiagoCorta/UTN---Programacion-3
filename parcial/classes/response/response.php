<?php

class Response {
    public static $res;
    public static function constructResponse($status, $body){
        self::$res = new stdClass();
        self::$res->status = $status;
        self::$res->body = $body;
        return json_encode(self::$res);
    }

}

function getStatus($condition){
    return $condition == true ? 'Success' : 'Fail';
}

function getBodyRes($condition, $type){
    switch($type){
        case 'singin':
            if($condition == true) return "Se registro correctamente el usuario";
            if($condition == false) return "Error al registrar usuario.";
            if($condition == null) return "Revise los datos enviados.";
        break;
        case 'login' :
            if($condition == true) return "Se Logeo correctamente";
            if($condition == false) return "Error email o contrasenia.";
            if($condition == null) return "Revise los datos enviados.";
        break;
        case 'pizza':
            if($condition == true) return "Se registro la pizza correctamente";
            if($condition == false || $condition == null) return "Error al registrar la pizza.";
        break;
        case 'venta':
                if($condition) return "Se registro venta correctamente monto :" . $condition;
                if($condition == false || $condition == null) return "Error en los datos o permisos.";
        break;
        case 'endPoint':
            return "Error endpoint invalido.";
        break;
        case 'method':
            return "Error metodo no soportado.";
        break;
    }
    
}
?>