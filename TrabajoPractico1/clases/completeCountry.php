<?php 

require_once '.\interfaces\iCountry.php';
require_once 'E:\xampp\htdocs\TrabajoPractico1\clases\baseCountry.php';

class CompleteCountry extends BaseCountry implements ICountry{
    public $timezones;
    public $subregion;
    public $callingCodes;
    public $borders;

    public function __construct($json){
        parent ::__construct($json);
       
    }

    public function getCountryData(){
        $string = parent::getCountryData();
        $string .= " <br>Timezones : " . $this->generateArrayString($this->timezones);
        $string .= " <br>SubRegion : " . $this->subregion;
        $string .= " <br>CallingCodes : " . $this->generateArrayString($this->callingCodes);
        $string .= " <br>Borders : " . $this->generateArrayString($this->borders);
        return $string;
    }


}