<?php

require_once "./classes/users/users.php";
require_once "./classes/files/files.php";
require_once "./classes/response/response.php";
require_once "./vendor/autoload.php";

//JWT
use \Firebase\JWT\JWT;
$requestPath = $_SERVER['PATH_INFO'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';
$key = "Prog3_thiago";

    // Crear una API rest con las siguientes rutas:
    // 1- POST signin: recibe email, clave, nombre, apellido, telefono y tipo (user, admin) y lo guarda en un archivo.
    // 2- POST login: recibe email y clave y chequea que existan, si es así retorna un JWT de lo contrario informa el error (si el email o la clave están equivocados) .
    // A PARTIR DE AQUI TODAS LAS RUTAS SON AUTENTICADAS.
    // 3- GET detalle: Muestra todos los datos del usuario actual.
    // 4- GET lista: Si el usuario es admin muestra todos los usuarios, si es user solo los del tipo user.

if($requestPath != ''){
    if($requestMethod == 'POST'){
        switch($requestPath){
            case '/signin':{
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $name = $_POST['name'] ?? '';
                $lastName = $_POST['lastName'] ?? '';
                $cellphone = $_POST['cellphone'] ?? '';
                $type = $_POST['type'] ?? '';
                $condition = null;
                if(checkConditions($email,$password,$name,$lastName,$cellphone,$type)){
                    $user = new User($name,$lastName,$password,$email,$cellphone,$type);
                    $file = new Files("users.dat");
                    $condition = $file->Save($user);
                }
                echo Response::constructResponse(getStatus($condition), getBodyRes($condition, "singin"));
            break;
            }
            case '/login':{
                echo 'hola';
                $file = new Files("users.dat");
                $user = $file->GetUser($_POST['email'],$_POST['password']);
                $condition = !!isset($user);
                $token = '';
                if($condition) $token = generateToken($user);
                echo Response::constructResponse(getStatus($condition),array(
                    "message" => getBodyRes($condition, 'login'),
                    "token" =>  $token
                ));
            break;
            }
            default:
                    echo Response::constructResponse("Error", getBodyRes(null,'endPoint'));
            break;
        }
    }else if($requestMethod == 'GET'){
        $headers = getallheaders();
        $token = $headers['token'] ?? '';
        if(isset($token)){
            try{
                $tokenDecode = JWT::decode($token, $key, array('HS256'));
                switch($requestPath){
                    case '/detalle':{
                        echo Response::constructResponse("Success", array( "UserData" => $tokenDecode));
                    break;
                    }
                    case '/lista': {
                        $file = new Files("users.dat");
                        $user = $file->GetUser($tokenDecode->email,$tokenDecode->password);
                        if(isset($user)) echo Response::constructResponse("Success", array( "UserList" => $file->GetUsers($user)));
                    break;
                    }
                    default:
                        echo Response::constructResponse("Error", getBodyRes(null,'endPoint'));
                    break;
                }
            }
            catch(Exception $e){
                echo Response::constructResponse("Error", $e->getMessage());
            }
            
        }
        
    }else{
        echo Response::constructResponse("Error", getBodyRes(null,'method'));
    }
}


function checkConditions($param1,$param2,$param3,$param4,$param5,$param6){
    if (($param1 != '') && ($param2 != '') && ($param3 != '') && ($param4 != '') && ($param5 != '') && ($param6 != '')) return true;
    return false;
}

function generateToken($user){
    $key = "Prog3_thiago";
    $tokenPayload = array(
        'name' => $user->name,
        'lastName' => $user->lastName,
        'password' => $user->password,
        'email' => $user->email,
        'cellphone' => $user->cellphone,
        'type' => $user->type
    );
    return JWT::encode($tokenPayload,$key);
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
        case 'endPoint':
            return "Error endpoint invalido.";
        break;
        case 'method':
            return "Error metodo no soportado.";
        break;
    }
    
}



?>
