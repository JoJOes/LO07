<?php
    require_once 'Fonction.php';
   class Vehicule{
       private $noPlaque, $marque, $modele, $transmission, $prix, $carburant;
       
       public function __contruct($noPlaque = null, $marque=null, $modele=null,$transmission=null,$prix=null,$carburant=null){
           if(!is_null($noPlaque)){
              $this->noPlaque=$noPlaque;
              $this->marque=$marque;
              $this->modele=$modele;
              $this->transmission=$transmission;
              $this->prix=$prix;
              $this->carburant=$carburant;    
           }
       }
       function setNoPlaque($noPlaque) {
           $this->noPlaque = $noPlaque;
       }
       function setMarque($marque) {
           $this->marque = $marque;
       }
       function setModele($modele) {
           $this->modele = $modele;
       }
       function setTranmission($transmission) {
           $this->transmission = $transmission;
       }
       function setPrix($prix) {
           $this->prix = $prix;
       }
       function setCarburant($carburant) {
           $this->carburant = $carburant;
       }
       function getNoPlaque() {
           $this->noPlaque;
       }
       function getMarque() {
           return $this->marque;
       }
       function getModele() {
           return $this->modele;
       }
       function getTranmission() {
           return $this->transmission;
       }
       function getPrix() {
           return $this->prix;
       }
       function getCarburant() {
           return $this->carburant;
       }
       public function toString(){
           printf("<td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%f</td>", 
           $this->getNoPlaque(), $this->getMarque(), $this->getModele(),$this->transmission, $this->getPrix());
       }
       public static function insert($noPlaque,$marque,$modele,$transmission,$prix,$carburant){
           try{
            $database=SModel::getInstance();
            $query="insert into table vehicule values (:noPlaque,:marque,:modele,:transmission,:prix,:carburant)";
            $statement=$database->prepare($query);
            $statemet->execute([
                'noPlaque'=>$noPlaque,
                'marque'=>$marque,
                'modele'=>$modele,
                'transmission'=>$transmission,
                'prix'=>$prix,
                'carburant'=>$carburant
            ]);
           } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
           }
       }
      public static function estGarable($noMarque,$dateDebut,$dateFin){
          try{
            $database = SModel::getInstance();
            $query = "select * from gare where vehicule_id = :noMarque)";
            $statement = $database->prepare($query);
            $statement->execute(['no_Marque'=>$noMarque]);
            $listeVehicule=$statement->fetchAll(PDO::FETCH_CLASS,"vehicule");
            $occupe=false;
            foreach($listeVehicule as $vehicule){
                if(!dateUtilisable($dateDebut, $dateFin, $gare->getDateDebut(), $gare->getDateFin())){
                    $occupe=true;
                    break;
                }
            }
            return $occupe;
          } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
          }
      }
      //verifier si elle est occupe lors de son gare
      public static function estOccupe($noMarque, $dateDebut, $dateFin){
          try{
          $database = SModel::getInstance();
          $query = "select * from location where vehicule_id = :noMarque and GETDATE()< :date_fin";
          $statement = $database->prepare($query);
          $statement->execute(['noMarque'=>$noMarque,'date_fin'=>$dateFin]);
          $listeLocation=$statement->fetchAll(PDO::FETCH_CLASS,"location");
          $occupe=false;
          if(size_of($listeLocation)==0){
              return true;
          }
          else{
              foreach ($listeLocation as $ele){
                  if(!dateUtilisable($dateDebut, $dateFin, $ele->getDateDebut(), $ele->getDateFin())){
                      $occupe=true;
                      break;
                  }
              }
          }
          return $occupe;
          } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
          }
      }
      public static function getVehiculeById($noMarque){
          $database = SModel::getInstance();
          $query = "select * from vehicule where no_marque = :noMarque)";
          $statement = $database->prepare($query);
          $statement->execute(['noMarque'=>$noMarque]);
          $vehicule=$statement->fetchAll(PDO::FETCH_CLASS,"vehicule");
          return $vehicule[0];
      }
   }
?>

