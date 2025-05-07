<?php
$servidor = "db";
$user = "usuari";
$password="paraula_de_pas";
$dbname="a24ikelopgom_Proyecto";

$connexion = new mysqli($servidor, $user, $password, $dbname);

if($connexion->connect_error){
    die("Error de conexión, intente de nuevo". $connexion->connect_error);
}