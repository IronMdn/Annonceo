<?php 
//-----------CENNEXION A LA BASE DE DONNEES---------------//
$pdo = new PDO('mysql:host=localhost;dbname=annonceo','root','passworD', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//----------------- SESSION
session_start();

//----------------- CHEMIN
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "/annonceo/"); // chemin physique du site
//echo '<pre>'; print_r($_SERVER); echo '</pre>';
define("URL", 'http://localhost/annonceo/'); // URL du site

//---------------- declaration de variable
$content = ''; // variable initialisée à vide qui permettra de contenir tout les différents messages d'alertes, elle sera disponible à tout moment. Pratique pour un affichage global

$message = '';

//--------------------------------------
// inclusions des fonctions 
require_once('fonction.inc.php');


?>
