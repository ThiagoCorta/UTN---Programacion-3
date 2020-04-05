<?php 

require_once '.\interfaces\iCountry.php';

class BaseCountry implements ICountry{

    public $name;
    public $region;
    public $capital;
    public $languages;
    public $currencies;

    function __construct($json){
        $jsonArray = json_decode($json, true);
        foreach($jsonArray as $key=>$value){
           $this->$key = $value;
        }
     }

    public function getCountryData(){
        $string = "Name : $this->name <br> Region : $this->region <br> Capital : $this->capital <br>";
        $string .= "Languages : " . $this->generateArrayString(...$this->languages) ."<br>";
        $string .= "Currencies : " . $this->generateArrayString(...$this->currencies);
        return $string;
    }

    public function generateArrayString($array){
        $string = "";
        foreach($array as $key=>$value) {
            $string .= $value ." ";
        }
        return $string;
    }

}

?>