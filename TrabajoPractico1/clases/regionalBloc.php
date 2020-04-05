<?php
require_once '.\interfaces\IContinent.php';
require_once 'E:\xampp\htdocs\TrabajoPractico1\clases\baseCountry.php';

class Continent implements IContinent{

 public $continentArray = [];

 function __construct(array $data) {
    foreach($data as $key => $val) {
        $country = new baseCountry(json_encode($data[$key]));
       array_push($this->continentArray, $country);
    }
}

 public function getContinentData(){
     $string = '';
     foreach($this->continentArray as $key => $val) {
       $string .= $this->continentArray[$key]->getCountryData() ."<br><br>";
     }
     echo $string;
 }

}
?>