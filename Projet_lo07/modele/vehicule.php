<?php
    require_once 'Fonction.php';
   class Vehicule{
       private $no_plaque, $marque, $modele, $transmission, $prix;
       
       public function __contruct($noPlaque = null, $marque=null, $modele=null,$transmission=null,$prix=null){
//           if(!is_null($noPlaque)){
              $this->no_plaque=$noPlaque;
              $this->marque=$marque;
              $this->modele=$modele;
              $this->transmission=$transmission;
              $this->prix=$prix;
//           }
       }
       function setNoPlaque($noPlaque) {
           $this->no_plaque = $noPlaque;
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
       function getNoPlaque() {
           return $this->no_plaque;
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
       public function toString(){
           $a='oui';
           if($this->getTranmission()==1){
               $a='non';
           }
           printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%.2f</td>", 
           $this->getNoPlaque(), $this->getMarque(), $this->getModele(),$a, $this->getPrix());
       }
       public static function insert($noPlaque,$marque,$modele,$transmission,$prix){
           try{
            $database=SModel::getInstance();
            $query="insert into vehicule values (:noPlaque,:marque,:modele,:transmission,:prix)";
            $statement=$database->prepare($query);
            $statement->execute([
                'noPlaque'=>$noPlaque,
                'marque'=>$marque,
                'modele'=>$modele,
                'transmission'=>$transmission,
                'prix'=>$prix,
            ]);
           } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
           }
       }
      public static function estGarable($no_plaque,$dateDebut,$dateFin){
          try{
             require_once './modele/gare.php';
            $database = SModel::getInstance();
            $query = "select * from gare where vehicule_id = :noMarque and date_fin>:dateDebut and date_debut<:dateFin";
            $statement = $database->prepare($query);
            $statement->execute(['noMarque'=>$no_plaque,'dateDebut'=>$dateDebut,'dateFin'=>$dateFin]);
            $listeGare=$statement->fetchAll(PDO::FETCH_CLASS,"gare");
            if(sizeof($listeGare)==0){
                return true;
            }
            else{
                return FALSE;
            }
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
      public static function getVehiculeById($noPlaque){
          $database = SModel::getInstance();
          $query = "select * from vehicule where no_plaque = :noPlaque";
          $statement = $database->prepare($query);
          $statement->execute(['noPlaque'=>$noPlaque]);
          $vehicule=$statement->fetchAll(PDO::FETCH_CLASS,"vehicule");
          if(sizeof($vehicule)==0){
              return NULL;
          }
          return $vehicule[0];
      }
      public static function modifierVehicule($noPlaque,$marque,$modele,$transmission,$prix){
          try{
            $database=SModel::getInstance();
            $query="UPDATE vehicule SET marque=:marque, modele=:modele, transmission=:transmission, prix=:prix where no_plaque=:noPlaque";
            $statement=$database->prepare($query);
            $statement->execute([
                'noPlaque'=>$noPlaque,
                'marque'=>$marque,
                'modele'=>$modele,
                'transmission'=>$transmission,
                'prix'=>$prix,
            ]);
            return true;
           } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
           }
      }
              
   }
?>

