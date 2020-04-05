
<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'E:\xampp\htdocs\TrabajoPractico1\clases\baseCountry.php';
require_once 'E:\xampp\htdocs\TrabajoPractico1\clases\regionalBloc.php';
require_once 'E:\xampp\htdocs\TrabajoPractico1\clases\completeCountry.php';
use NNV\RestCountries;

$restCountries = new RestCountries;
$country = new BaseCountry(json_encode(...$restCountries->byCapitalCity('Buenos Aires')));
$continent = new Continent($restCountries->byRegion("asia"));
$completeCountry = new CompleteCountry(json_encode(...$restCountries->byCapitalCity('Buenos Aires')));

echo "PAIS ----------------------------<br><br>";
echo $country->getCountryData();
echo "<br><br>---------------------------------<br><br>";
echo "PAIS COMPLETO ----------------------------<br><br>";
echo $completeCountry->getCountryData();
echo "<br><br>---------------------------------<br><br>";
echo "Continente --------------------------<br><br>";
echo $continent->getContinentData();

