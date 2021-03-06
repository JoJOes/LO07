<?php
require_once 'modele/vehicule.php';
require_once 'modele/utilisateur.php';
require_once 'modele/place.php';
require_once 'modele/SModel.php';
require_once 'Fonction.php';
class Gare{
    private  $vehicule_id,$place_id,$site_id,$date_debut,$date_fin,$prix;
    public function __contruct($vehiculeId, $placeId,$siteId,$dateDebut, $dateFin,$prix){
        if(!is_null($vehiculeId)){
            $this->place_id=$placeId;
            $this->vehicule_id=$vehiculeId;
            $this->date_debut=$dateDebut;
            $this->date_fin=$dateFin;
            $this->site_id=$siteId;
            $this->prix=$prix;

        }
    }
    function setPlaceId($placeId) {
        $this->place_id = $placeId;
    }
    function setSiteId($siteId){
        $this->site_id=$siteId;
    }
    function setVehiculeId($vehiculeId) {
        $this->vehicule_id = $vehiculeId;
    }
    function setDateDebut($dateDebut) {
        $this->date_debut = $dateDebut;
    }
    function setDateFin($dateFin) {
        $this->date_fin = $dateFin;
    }
    function setPrix($prix) {
        $this->prix = $prix;
    }
    function getPlaceId() {
        return $this->place_id;
    }
    function getSiteId(){
        return $this->site_id;
    }
    function getVehiculeId() {
        return $this->vehicule_id;
    }

    function getDateDebut() {
        return $this->date_debut;
    }

    function getDateFin() {
        return $this->date_fin;
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
//           if(gare::estGarable($vehiculeId,$place_id,$dateDebut,$dateFin)){
            $database=SModel::getInstance();
            $query="insert into gare values (:vehicule_id,:place_id ,:site_id,:date_debut,:date_fin,:prix)";
            $statement=$database->prepare($query);
            $statement->execute([
                'vehicule_id'=>$vehicule_id,
                'place_id'=>$place_id,
                'site_id'=>$site_id,
                'date_debut'=>$date_debut,
                'date_fin'=>$date_fin,
                'prix'=>$prix
            ]);
          return true;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function annulerReservation($vehiculeId,$placeId,$siteId,$dateDebut,$dateFin){
        try{
          $database=SModel::getInstance();
           $query="delete from gare where vehicule_id= :vehicule_id and place_id =:place_id and site_id=:siteId and date_debut= :date_debut and date_fin=:date_fin";
           $statement=$database->prepare($query);
           $statement->execute([
               'vehicule_id'=>$vehiculeId,
               'place_id'=>$placeId,
               'date_debut'=>$dateDebut,
               'date_fin'=>$dateFin,
               'siteId'=>$siteId
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
//          require_once './modele/vehicule.php';
          $listeVehicules=utilisateur::getVehicules($id);
          $database=SModel::getInstance();
//          $now= getdate();
          $format = "%H:%M:%S %d-%B-%Y";
//          $newdate = date($format, $now);
            $timestamp = date("y-m-d H:M:S ");
//             $strTime = strftime($format, $timestamp );
             $strTime=date("y-m-d H:M:S");
//             $strTime->format(H:M:S d-B-Y);
//            $strTime = strftime($format, $now );
          $compteur=0;
          foreach  ($listeVehicules as $ele){
            $query="select G.vehicule_id, G.place_id, S.label, G.date_debut, G.date_fin, G.prix, G.site_id from gare as G, site as S where G.vehicule_id=:vehicule_id and G.site_id=S.id and date_fin > :date";
            $statement=$database->prepare($query);
            $statement->execute([
                'vehicule_id'=>$ele->getNoPlaque(),
                'date'=>$strTime,
            ]);
            while($ligne = $statement->fetch()){
              $compteur++;
              echo'<tr>';
              printf("<td>%d</td>",$compteur);
              printf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%.2f</td>",$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5]);
              echo '<td>';
              $form_id='form-'.$compteur;
              printf( "<form id='%s' action='router.php' method='get'>",$form_id);
              printf("<input type='hidden' name='action' value='supprimerReservation'>");
              printf("<input type='hidden' name='vehiculeId' value='%s'>",$ligne[0]);
              printf("<input type='hidden' name='placeId' value='%d'>",$ligne[1]);
              printf("<input type='hidden' name='siteId' value='%s'>",$ligne[6]);
              printf("<input type='hidden' name='dateDebut' value='%s'>",$ligne[3]);
              printf("<input type='hidden' name='dateFin' value='%s'>",$ligne[4]);
              printf("<input type='hidden' name='prix' value='%.2f'>",$ligne[5]);
              printf("<input class='btn btn-danger' type='button' onclick='supprimerReservation(\"%s\",\"%.2f\")' value='supprimer'>",$form_id,$ligne[5]);
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