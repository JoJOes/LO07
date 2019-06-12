<?php
require_once 'modele/vehicule.php';
require_once 'modele/utilisateur.php';
require_once 'modele/place.php';
require_once 'modele/SModel.php';
require_once 'Fonction.php';
class Gare{
    private  $vehiculeId,$placeId,$siteId,$dateDebut,$dateFin,$prix;
    public function __contruct($vehiculeId, $placeId,$siteId,$dateDebut, $dateFin,$prix){
        if(!is_null($vehiculeId)){
            $this->placeId=$placeId;
            $this->vehiculeId=$vehiculeId;
            $this->dateDebut=$dateDebut;
            $this->dateFin=$dateFin;
            $this->siteId=$siteId;
            $this->prix=$prix;

        }
    }
    function setPlaceId($placeId) {
        $this->placeId = $placeId;
    }
    function setSiteId($siteId){
        $this->siteId=$siteId;
    }
    function setVehiculeId($vehiculeId) {
        $this->vehiculeId = $vehiculeId;
    }
    function setDateDebut($dateDebut) {
        $this->dateDebut = $dateDebut;
    }
    function setDateFin($dateFin) {
        $this->dateFin = $dateFin;
    }
    function setPrix($prix) {
        $this->prix = $prix;
    }
    function getPlaceId() {
        return $this->placeId;
    }
    function getSiteId(){
        return $this->siteId;
    }
    function getVehiculeId() {
        return $this->vehiculeId;
    }

    function getDateDebut() {
        return $this->dateDebut;
    }

    function getDateFin() {
        return $this->dateFin;
    }
    function getPrix(){
        return $this->prix;
    }
    public function toString(){
        printf("<td>%d</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td>", 
        $this-> $this->getVehiculeId(), getPlaceId(),getSiteId(), $this->getDateDebut(), $this->dateFin());
    }
    //pour verifier si cette voiture est deja gare' ou si cette place est deja occupe
    public static function estGarable($vehiculeId,$place_id,$siteId,$dateDebut,$dateFin){
        try{
            if(vehicule::estGarable($vehiculeId, $dateDebut, $dateFin) && !place::estOccupe($place_id, $dateDebut, $dateFin)){
                return true;
            }
            return false;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }  
    }
    //pour ajouter la voiture dans la liste Gare
    public static function reserverPlace($vehicule_id,$place_id,$site_id,$date_debut,$date_fin,$prix){
        try{
           if(gare::estGarable($vehiculeId,$place_id,$dateDebut,$dateFin)){
                $database=SModel::getInstance();
                $query="insert into table gare values (:vehicule_id,:place_id ,:site:id,:date_debut,:date_fin,:prix)";
                $statement=$database->prepare($query);
                $statement->execute([
                    'vehicule_id'=>$vehicule_id,
                    'place_id'=>$place_id,
                    'site_id'=>$site_id,
                    'date_debut'=>$date_debut,
                    'date_fin'=>$date_fin,
                    'prix'=>$prix
                ]);
           }
           else {
               return false;
           }
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function annulerReservation($vehiculeId,$placeId,$dateDebut,$dateFin){
        try{
          $database=SModel::getInstance();
           $query="delete from table gare where vehicule_id= :vehicule_id and place_id =:place_id and date_debut= :date_debut and date_fin=:date_fin";
           $statement=$database->prepare($query);
           $statement->execute([
               'vehicule_id'=>$vehiculeId,
               'place_id'=>$placeId,
               'date_debut'=>$dateDebut,
               'date_fin'=>$dateFin
           ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function getElementsByIdUtilisateur($id){
        try{
          $listeVehicules=utilisateur::getVehicule($id);
          $database=SModel::getInstance();
          $listeReservation=array();
          foreach  ($listeVehicules as $ele){
             $query="select * from gare where vehicule_id=:vehicule_id and date_fin > GETDATE()";
             $statement=$database->prepare($query);
             $statement->execute([
                 'vehicule_id'=>$ele.getNoPlaque(),
             ]);
              $listeGare=$statement->fetchAll(PDO::FETCH_CLASS,"gare");
              foreach($listeGare as $val){
                  $listeReservation[]=$val;
              }
          }
          return $listeReservation;
           
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function afficherReservation($id){
        try{
          $listeVehicules=utilisateur::getVehicule($id);
          $database=SModel::getInstance();
          foreach  ($listeVehicules as $ele){
            $query="select G.vehicule_id G.place_id S.label G.date_debut G.date_fin G.prix from gare as G, site as S where G.vehicule_id=:vehicule_id and G.site_id=S.id and date_fin > GETDATE()";
            $statement=$database->prepare($query);
            $statement->execute([
                'vehicule_id'=>$ele.getNoPlaque(),
            ]);
            $compteur=1;
            while($ligne = mysqli_fetch_array($statement,MYSQLI_NUM)){
              echo'<tr>';
              printf("<td>%d</td>",$compteur);
              printf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%f</td>",$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5]);
              echo '<td>';
              echo "<form action='router.php?action=supprimer' method='post'>";
              printf("<input type='hidden' name='vehiculeId' valu   e='%s'>",$ligne[0]);
              printf("<input type='hidden' name='placeId' value='%d'>",$ligne[1]);
              printf("<input type='hidden' name='Label' value='%s'>",$ligne[2]);
              printf("<input type='hidden' name='dateDebut' value='%s'>",$ligne[3]);
              printf("<input type='hidden' name='dateFin' vallue='%s'>,$ligne[4]");
              printf("<input type='hidden' name='prix' vallue='%f'>,$ligne[5]");
              echo"<input type='submit' value='supprimer'>";
              echo'</form>';
              echo'</td>';
              echo'</tr>';
            }
              
          }
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

}