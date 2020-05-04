<?php
class Venta{
    public $email;
    public $tipo;
    public $monto;
    public $fecha;

    public function Vender($tipo,$sabor,$user){
        $pizza = Pizza::getPizza($tipo,$sabor);
        if(!$pizza || $pizza->stock < 1) return false;
        $this->email = $user->email;
        $this->tipo = $pizza->tipo;
        $this->monto = $pizza->precio;
        $this->fecha = date("Y/m/d");
        $pizza->stock -= 1;
        if(self::GuardarVenta($this, $user)){
            return $this->monto;
        }
    }


    public static function GuardarVenta($venta, $user){
        
        if($user->tipo == 'cliente'){
            $file = new Files("ventas.dat");
            return $file->Save($venta);
        }
       
    }

    public static function LeerVentas($user){
        $file = new Files("ventas.dat");
        $ventas = $file->getAllData();

        if($user->tipo == 'encargado'){
            $retorno = new stdClass();
            $retorno->cantidad = 0;
            $retorno->monto = 0;
            foreach ($ventas as $key => $value) {
                $retorno->cantidad++;
                $retorno->monto += $value->monto;
            }
            return json_encode($retorno);
        }else if($user->tipo == 'cliente'){
            $newArray = array();
            foreach ($ventas as $key => $value) {
                if($value->email == $user->email){
                    array_push($newArray,$value);
                }
            }
            return json_encode($newArray);
        }

    }

    
}



?>