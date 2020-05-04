<?php
require __DIR__ . '/vendor/autoload.php';
require_once "./classes/usuario.php";
require_once "./classes/files/files.php";
require_once "./classes/response/response.php";
require_once "./classes/login/login.php";
require_once "./classes/pizza.php";
require_once "./classes/venta.php";

$requestPath = $_SERVER['PATH_INFO'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

if($requestPath != ''){
    if($requestMethod == 'POST'){
        switch($requestPath){
            case '/usuario':{
                $condition = false;
                if(Usuario::validateBodyReq($_POST)){
                    $cliente = new Usuario($_POST);
                    $file = new Files("users.dat");
                    $condition = $file->Save($cliente);
                }
                echo Response::constructResponse(getStatus($condition), getBodyRes($condition, "singin"));
            break;
            }
            case '/login':{
                $email = $_POST['email'] ?? null;
                $clave = $_POST['clave'] ?? null;
                if($email && $clave){
                    $login = new Login($email,$clave);
                    $token = '';
                    if($login->isValidUser) $token = $login->generateToken();
                }
                echo Response::constructResponse(getStatus($login->isValidUser),array(
                    "message" => getBodyRes($login->isValidUser, 'login'),
                    "token" =>  $token
                ));
            break;
            }
            
            case '/pizzas':{
                $tokenDecode = Login::decodeToken();
                $condition = false;
                if($tokenDecode && Pizza::validateBodyReq($_POST)){
                    $pizza = new Pizza($_POST);
                    $condition = $pizza->savePizza($pizza, $tokenDecode);                    
                }
                echo Response::constructResponse(getStatus($condition),getBodyRes($condition, 'pizza'));
                
            break;
            }

            case '/ventas':{
                $token = Login::decodeToken();
                if(isset($token)){
                    $venta = new Venta();
                    $monto = $venta->Vender($_POST['tipo'],$_POST['sabor'],$token);
                    $condition = $monto ? true : false;
                }
                echo Response::constructResponse(getStatus($condition),getBodyRes($monto, 'venta'));
            break;
            }
            
            default:
                    echo Response::constructResponse("Error", getBodyRes(null,'endPoint'));
            break;
        }
    }else if($requestMethod == 'GET'){
        $token = Login::decodeToken();
        if(isset($token)){
            try{
                switch($requestPath){
                    case '/pizzas':{
                        echo Pizza::getPizzas($token);
                    break;
                    }
                    case '/ventas': {
                       echo Venta::LeerVentas($token);
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