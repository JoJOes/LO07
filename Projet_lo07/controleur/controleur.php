<?php

//require './modele/utilisateur.php';
//require
class controleur {
    public static function accueil(){
        session_start();
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
        else{
            require_once './modele/site.php';
            require_once './modele/utilisateur.php';
            site::mettreAJourNombrePlace($_GET['list-aeroport'],$_GET['datedebut'],$_GET['datefin']);
            $listeSites=site::getListeSite($_GET['list-aeroport']);
            $listeVehicules= utilisateur::getVehicules($_SESSION['id']);
            $date1=$_GET['datedebut'];
            $date2=$_GET['datefin'];
            require './vue/pageReservation2.php';
        }
    }
    public static function reservation3(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
        else{
            require_once './modele/vehicule.php';
            require_once'./modele/site.php';
            if(vehicule::estGarable($_GET['list-vehicules'], $_GET['datedebut'], $_GET['datefin'])==false){
                $message="<script>alert('LA VOITURE EST DEJA GAREE');</script>";
                echo $message;
                session_abort();
                controleur::reservation2();
            }
            else if(site::getSiteById($_GET['list-sites'])->getNombrePlace()==0){
                $message="<script>alert('accune place disponible dans cette site');</script>";
                echo $message;
                session_abort();
                controleur::reservation2();
            }
            else{
    //            echo $_GET['list-vehicules'];
            require_once'./modele/place.php';
            $listePlaces=place::getListePlaceDisponible($_GET['list-sites'],$_GET['datedebut'],$_GET['datefin']);
            $tempsTotal= getTemps($_GET['datedebut'],$_GET['datefin']);
            $site=site::getSiteById($_GET['list-sites']);
            $prix=$site->getPrixJour();
            require './vue/pageReservation3.php';
            }
        }
        
    }
    public static function validerReservation(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require './vue/login.php';
        }
        else{
            require_once './modele/gare.php';
            Gare::reserverPlace($_GET['vehicule_id'], $_GET['list-places'], $_GET['site_id'], $_GET['datedebut'], $_GET['datefin'], $_GET['prix']);
    //        Gare::reserverPlace($_GET['vehicule_id'], $_GET['list-places'], $_GET['site_id'], strtotime($_GET['datedebut']), strtotime($_GET['datefin']), $_GET['prix']);
            $message="<script>alert('La reservation a ete reussie');</script>";
            echo $message;
            require './vue/accueil.php';
        }
    }
    public static function voirProfil(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
        else{
            require_once './modele/utilisateur.php';;
            $id=$_SESSION['id'];
            $utilisateur= utilisateur::getUtilisateurById($id);
            $listeVehicules= utilisateur::getVehicules($id);
            require './vue/profil.php';
            printf("<script>$('#info').click()</script>");
        }
        
    }
    public static function voirVehicule(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
        else{
            session_abort();
            controleur::voirProfil();
            printf("<script>$('#vehicule').click()</script>");
        }
        
    }
    public static function voirReservation(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
        else{
//            require './modele/utilisateur.php';;
//            $id=$_SESSION['id'];
//            $utilisateur= utilisateur::getUtilisateurById($id);
//            $listeVehicules= utilisateur::getVehicules($id);
//            require './vue/profil.php';
            session_abort();
            controleur::voirProfil();
            printf("<script>$('#reservation').click()</script>");
        }
        
    }
    public static function deconnecter(){
        session_start();
        if(!isset($_SESSION['id'])){
            require './vue/login.php';
        }
        else{
            unset($_SESSION['id']);
            require './vue/accueil.php';
        }
    }
    public static function validerModificationInformation(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require_once './modele/utilisateur.php';
            utilisateur::modifierNomPrenom($_SESSION['id'],$_GET['nom'], $_GET['prenom']);
            $message="<script>alert('La modification a ete reussie');</script>";
            echo $message;
            session_abort();
            controleur::voirProfil();
        }
    }
    public static function validerModificationMotDePasse(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require_once './modele/utilisateur.php';
            utilisateur::modifierMotDePasse($_SESSION['id'], $_POST['motdepasse']);
            $message="<script>alert('La modification a ete reussie');</script>";
            echo $message;
            session_abort();
            controleur::voirProfil();
        }
    }
    public static function modifierVehicule(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require_once './modele/vehicule.php';
            $vehicule=Vehicule::getVehiculeById($_GET['noplaque']);
            require'./vue/modificationVehicule.php';
        }
    }
    public static function validerModificationVehicule(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require_once './modele/vehicule.php';
            if($_GET['transmission']=='non'){
                 $transmission=0;
            }
            else{
                 $transmission=1;
            }
            if(Vehicule::modifierVehicule($_GET['noPlaque'], $_GET['marque'],$_GET['modele'],$transmission,$_GET['prix'])){
                $message="<script>alert('La modification a ete reussie');</script>";
                echo $message;
            }
            else{
                $message="<script>alert('ERREUR!');</script>";
                echo $message;
            }
            session_abort();
            controleur::voirVehicule();
        }
    }
    public static function supprimerVehicule(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else {
            require_once './modele/utilisateur.php';
            utilisateur::supprimerVehicule($_SESSION['id'], $_GET['noplaque']);
            session_abort();
            controleur::voirVehicule();
        }
    }
    public static function ajouterVehicule(){
        session_start();
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require './vue/ajouterVehicule.php';
        }
    }
    public static function validerAjouteVehicule(){
        session_start();
        require_once './modele/utilisateur.php';        
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            if(utilisateur::possederVehicule($_SESSION['id'],$_GET['no-plaque'])==1){
                $message="<script>alert('Deja possede!');</script>";
                echo $message;
            }
            else if(utilisateur::possederVehicule($_SESSION['id'],$_GET['no-plaque'])==3){
                $message="<script>alert('Vehicule existe pas!');</script>";
                echo $message;
            }
            else {
                if(isset($_GET['creer'])==false){
                    utilisateur::ajouterVehicule($_SESSION['id'], $_GET['no-plaque'], null, null, null, null);
                }
                else if(isset($_GET['creer'])==true){
                    require_once './modele/utilisateur.php';
                    utilisateur::ajouterVehicule($_SESSION['id'], $_GET['no-plaque'], $_GET['marque'], $_GET['modele'], $_GET['transmission'], $_GET['prix']);
                }
                $message="<script>alert('Ajoute a ete reussi!');</script>";
                echo $message;
            }
            session_abort();
            controleur::voirVehicule();
        }
    }
    public static function supprimerReservation(){
        session_start();
        require_once './modele/utilisateur.php';        
        if(isset($_SESSION['id'])==false){
            require'./vue/login.php';
        }
        else{
            require_once './modele/gare.php';
            Gare::annulerReservation($_GET['vehiculeId'], $_GET['placeId'],$_GET['siteId'], $_GET['dateDebut'], $_GET['dateFin']);
            session_abort();
            controleur::voirReservation();
        }
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
