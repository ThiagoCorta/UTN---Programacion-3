<?php
class Pizza{
    public $sabor;
    public $tipo;
    public $precio;
    public $stock;
    public $foto;


    public function __construct($obj){        
        $this->sabor = $obj['sabor'];        
        $this->tipo = $obj['tipo'];
        $this->precio = $obj['precio'];
        $this->stock = $obj['stock'];
        $this->foto = Files::processImage($this->tipo.'-'.$this->sabor,$_FILES['foto']);
    }

    public static function validateBodyReq($post){
        if(count($post) != count(array_filter($post))) return false;
        $sabor = $post['sabor'];
        $tipo = $post['tipo'];
        if($tipo == 'molde' || $tipo == 'piedra'){
            if($sabor == 'jamon' || $sabor == 'napo' || $sabor == 'muzza'){
                $bodyReq = ['precio', 'stock'];
                foreach($bodyReq as $key=>$field){
                    if(!isset($post[$field])) return false;
                }
                return isset($_FILES['foto']);
            }
        }
       return false;
    }


    public function savePizza($data, $user){
        if(strtolower($user->tipo) == "encargado"){
            $file = new Files("pizzas.dat");
            $condition = self::checkPizzaExist($data);
            if($condition == false) return $file->Save($this);
        }
        return false;
    }

    public static function checkPizzaExist($data){
        $file = new Files("pizzas.dat");
        $pizzas = $file->getAllData();
        foreach ($pizzas as $key => $value) {
            if($value->tipo == $data->tipo ) {
                if($value->sabor == $data->sabor){
                    return true;
                }
             }       
        }
        return false;
    }
    public static function getPizzas($user){
        $file = new Files("pizzas.dat");
        if($user->tipo == 'encargado'){
            return json_encode($file->getAllData());
        }else if($user->tipo == 'cliente'){
            $newArray = array();
            foreach ($file->getAllData() as $key => $value) {
                unset($value->stock);
                array_push($newArray,$value);
            }
            return json_encode($newArray);
        }
        return false;
    }

    public static function getPizza($tipo,$sabor){
        $file = new Files("pizzas.dat");
        $pizzas = $file->getAllData();
        if($pizzas == []) return false;
        foreach ($pizzas as $key => $value) {
            if($value->tipo == $tipo){
                if($value->sabor == $sabor){
                    return $value;
                }
            } 
        }
        return false;
    }
    


}



?>