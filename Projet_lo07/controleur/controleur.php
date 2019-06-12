<?php

require './modele/utilisateur.php';

class controleur {
    public static function accueil(){
        require './vue/accueil.php';
    }
            
    public static function login() {
        require ('./vue/login.php');
    }

    public static function inscription() {
        require ('./vue/inscription.php');
    }
    public static function validerLogin() {
        
        if(!utilisateur::verifierAcces($_POST['login'], $_POST['motDePasse'])){
            $message='ERREUR DE CONNEXION!';
            printf("<script>alert(%s)</script>",$message);
            require './vue/login.php';
        }
        else{
            require ('./vue/accueil.php');
        }
    }
//    public static function loginFalse(){
//        $message='ERREUR DE CONNEXION!';
//        printf("<script>alert(%s)</script>",$message);
//        require '../vue/login.php';
//    }
    public static function validerInscription(){
        if(utilisateur::verifierInscription($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse'])==2){
            $message='FORMULAIRE INCOMPLET!';
            printf("<script>alert(%s)</script>",$message);
            require ('./vue/inscription.php');
        }
        else if(utilisateur::verifierInscription($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse'])==1){
            $message='LE LOGIN EXISTE DEJA!';
            printf("<script>alert(%s)</script>",$message);
            require ('./vue/inscription.php');
        }
        else{
            require ('./vue/inscriptionReussite.php');
        }
    }
    // Affiche un vin particulier (id)
    public static function read() {
        require ('app/view/viewVinIDForm.php');      
    }
    
    // Affiche un vin particulier (id)
    public static function idFormAction() {
        $vin_id = $_GET['id'];
        $results = ModelVin::read($vin_id);
        require 'app/view/viewVinList.php';
    }
    
    // Affiche le formulaire de creation d'un vin
    public static function create() {
        require ('app/view/viewVinForm.php'); 
    }

    // Ajout des données d'un nouveau vin et affiche un message de confirmation
    public static function created() {
        // ajouter une validation des informations du formulaire
        $results = ModelVin::insert ($_GET['id'], $_GET['cru'], $_GET['annee'], $_GET['degre']);
        require 'app/view/viewVinCreated.php';
    }
   
    // Ajout des données d'un nouveau vin et affiche un message de confirmation    
    public static function delete() {
        require ('app/view/viewVinIDForm.php');  
    }
}
?>
<script>
    function aleter($message){
        alert($message);
    }
</script>
