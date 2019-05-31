<?php
require_once 'modele/vehicule.php';
require_once 'modele/place.php';
require_once 'modele/SModel.php';
require_once 'Fonction.php';
class Gare{
    private  $vehiculeId,$placeId,$dateDebut,$dateFin;
    public function __contruct($vehiculeId, $placeId, $dateDebut, $dateFin){
        if(!is_null($vehiculeId)){
            $this->placeId=$placeId;
            $this->vehiculeId=$vehiculeId;
            $this->dateDebut=$dateDebut;
            $this->dateFin=$dateFin;
        }
    }
    function setPlaceId($placeId) {
        $this->placeId = $placeId;
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
    function getPlaceId() {
        return $this->placeId;
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
    public function toString(){
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>", 
        $this-> $this->getVehiculeId(), getPlaceId(), $this->getDateDebut(), $this->dateFin());
    }
    //pour verifier si cette voiture est deja gare' ou si cette place est deja occupe
    public static function estGarable($vehiculeId,$place_id,$dateDebut,$dateFin){
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
    public static function reserverPlace($vehicule_id,$place_id,$date_debut,$date_fin){
        try{
           if(gare::estGarable($vehiculeId,$place_id,$dateDebut,$dateFin)){
                $database=SModel::getInstance();
                $query="insert into table gare values (:vehicule_id,:place_id ,:date_debut,:date_fin)";
                $statement=$database->prepare($query);
                $statement->execute([
                    'vehicule_id'=>$vehicule_id,
                    'place_id'=>$place_id,
                    'date_debut'=>$date_debut,
                    'date_fin'=>$date_fin
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

}