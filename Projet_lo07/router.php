<?php

require'./controleur/controleur.php';

// récupération de l'action passée dans l'URL
$query_string = $_SERVER['QUERY_STRING'];

// fonction parse_str permet de construire une table de hachage (clé + valeur)
parse_str($query_string, $param);

// $action contient le nom de la méthode statique recherchée
$action = $param["action"];

switch ($action) {
    case "login" :
    case "inscription":
    case "validerLogin":
//    case "loginFalse":
    case "validerInscription":
    case "reservation1":
    case "reservation2":
    case "reservation3":
    case "validerReservation":
    case "voirProfil":
    case "voirReservation":
    case "voirVehicule":
    case "deconnecter":
    break;

    default:
        $action = "accueil";
}


// appel de la méthode statique $action de ControllerVin2
controleur::$action();


