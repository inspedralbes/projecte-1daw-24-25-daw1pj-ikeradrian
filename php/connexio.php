<?php
$servidor = "daw.inspedralbes.cat";
$user = "a22adrmacfir_admin_incidencies";
$password="fx*Qz8gbIp!#i=um";
$dbname="a22adrmacfir_incidencies";

$connexion = new mysqli($servidor, $user, $password, $dbname);

if($connexion->connect_error){
    die("Error de conexión, intente de nuevo". $connexion->connect_error);
}
require 'vendor/autoload.php';

$uri = "mongodb+srv://a24ikelopgom:Dzsi7L4hfy9Y3niO@grupo4.vmvzio9.mongodb.net/?retryWrites=true&w=majority&appName=Grupo4";

$client = new MongoDB\Client($uri);

$collection = $client->demo->users;
