<?php

//require './modele/utilisateur.php';
//require
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
        require './modele/utilisateur.php';
        if(!utilisateur::verifierAcces($_POST['login'], $_POST['motDePasse'])){
            $message="<script>alert('ERREUR DE CONNEXION');</script>";
            echo $message;
//            printf("<script>alert(%s);</script>",'a');
//            echo'<script>run();</script>';
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
        require './modele/utilisateur.php';
        if(utilisateur::verifierInscription($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse'])==2){
              $message="<script>alert('FORMULAIRE INCOMPLET');</script>";
              echo $message;
//            $message='FORMULAIRE INCOMPLET!';
//            printf("<script>alert(%s)</script>",$message);
            require ('./vue/inscription.php');
        }
        else if(utilisateur::verifierInscription($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse'])==1){
            $message="<script>alert('LOGIN EXISTE DEJA');</script>";
            echo $message;
            require ('./vue/inscription.php');
        }
        else if(utilisateur::verifierInscription($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse'])==3){
            utilisateur::insert($_POST['login'],$_POST['nom'],$_POST['prenom'],$_POST['motDePasse']);
            require ('./vue/inscriptionReussite.php');
        }
    }
    public static function reservation1(){
        session_start();
//        unset($_SESSION['id']);
        if(isset($_SESSION['id'])){
            require 'Fonction.php';
            $listeAeroports= getListeAeroports();
            require './vue/pageReservation1.php';
        }
        else{
            require './vue/login.php';
        }
    }
    public static function reservation2(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
//        else if(($_GET['list-aeroport']=='')||!isset($_GET['date1'])||!isset($_GET['date2'])){
         else if(($_GET['list-aeroport']=='')||($_GET['date1']=='')||($_GET['date2']=='')){
            $message="<script>alert('FORMULAIRE INCOMPLET');</script>";
            echo $message;
            require 'Fonction.php';
            $listeAeroports= getListeAeroports();
            require './vue/pageReservation1.php';
            require './vue/pageReservation1.php';
        }
        else{
            require './modele/site.php';
            require './modele/utilisateur.php';
            $listeSites=site::getListeSite($_GET['list-aeroport']);
            $listeVehicules= utilisateur::getVehicules($_SESSION['id']);
            foreach ($listeSites as $ele){
                site::mettreAJourNombrePlace($ele->getId(), strtotime($_GET['date1']), strtotime($_GET['date2']));
            }
//            foreach($listeSites as $val){
//                echo '<table>';
//                $val->toString();
//                echo'</table>';
//            }
            $date1=$_GET['date1'];
            $date2=$_GET['date2'];
            require './vue/pageReservation2.php';
        }
    }
    public static function reservation3(){
        session_start();
        require './modele/vehicule.php';
        require'./modele/site.php';
//        echo $_GET['datedebut'];
        if($_GET['list-sites']==''||$_GET['list-vehicules']==''){
            $message="<script>alert('FORMULAIRE INCOMPLET');</script>";
            echo $message;
            $date1=$_GET['datedebut'];
            $date2=$_GET['datefin'];
            require './modele/utilisateur.php';
            $listeSites=site::getListeSite($_GET['list-aeroport']);
            $listeVehicules= utilisateur::getVehicules($_SESSION['id']);
            foreach ($listeSites as $ele){
                site::mettreAJourNombrePlace($ele->getId(), strtotime($date1), strtotime($_GET['date2']));
            }
            require './vue/pageReservation2.php';
        }
        else if(!vehicule::estGarable($_GET['list-vehicules'], strtotime($_GET['datedebut']), strtotime($_GET['datefin']))){
            $message="<script>alert('LA VOITURE EST DEJA GAREE');</script>";
            echo $message;
            $date1=$_GET['datedebut'];
            $date2=$_GET['datefin'];
            require './modele/utilisateur.php';
            $listeSites=site::getListeSite($_GET['list-aeroport']);
            $listeVehicules= utilisateur::getVehicules($_SESSION['id']);
            foreach ($listeSites as $ele){
                site::mettreAJourNombrePlace($ele->getId(), strtotime($_GET['date1']), strtotime($_GET['date2']));
            }
            require './vue/pageReservation2.php';
        }
        else if(site::getSiteById($_GET['list-sites'])->getNombrePlace()==0){
            $message="<script>alert('accune place disponible dans cette site');</script>";
            echo $message;
        }
        else{
//            echo $_GET['list-vehicules'];
        require_once'./modele/place.php';
        $listePlaces=place::getListePlaceDisponible($_GET['list-sites'],strtotime($_GET['datedebut']), strtotime($_GET['datefin']));
//                $listePlaces=place::getListePlaceDisponible($_GET['list-sites'],$_GET['datedebut'], $_GET['datefin']);
        $tempsTotal= getTemps($_GET['datedebut'],$_GET['datefin']);
        $site=site::getSiteById($_GET['list-sites']);
        $prix=$site->getPrixJour();
        require './vue/pageReservation3.php';
        }
    }
    public static function validerReservation(){
        
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
    function alerter($message){
        alert($message);
    }
    function run(){
        alert('ngu nhu bo');
    }
</script>
