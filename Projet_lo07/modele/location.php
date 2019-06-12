
<?php
require_once 'modele/site.php';
require_once 'modele/vehicule.php';
require_once 'modele/SModel.php';
require_once 'Fonction.php';
class Gare{
    private $utilisateurId, $vehiculeId, $dateDebut2,$dateFin2,$prix;
    public function __contruct($utilisateurId, $vehiculeId, $dateDebut2, $dateFin2,$prix){
        if(!is_null($utilisateur)){
            $this->utilisateurId=$utilisateurId;
            $this->vehiculeId=$vehiculeId;
            $this->dateDebut2=$dateDebut2;
            $this->dateFin2=$dateFin2;
            $this->prix=$prix;
        }
    }
     function setPrix($prix) {
        $this->prix = $prix;
    }
    function setUtilisateurId($utilisateurId) {
        $this->utilisateurId = $utilisateurId;
    }
    function setVehiculeId($vehiculeId) {
        $this->vehiculeId = $vehiculeId;
    }
    function setDateDebut($dateDebut2) {
        $this->dateDebut2 = $dateDebut2;
    }
    function setDateFin($dateFin2) {
        $this->dateFin2 = $dateFin2;
    }
    function getUtilisateurId() {
        return $this->utilisateurId;
    }

    function getVehiculeId() {
        return $this->vehiculeId;
    }

    function getDateDebut() {
        return $this->dateDebut2;
    }

    function getDateFin() {
        return $this->dateFin2;
    }
    public function toString(){
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>", 
        $this->getUtilisateurId(), $this->getVehiculeId(), $this->getDateDebut(), $this->dateFin());
    }
    function getPrix(){
        return $this->prix;
    }
   
    //pour ajouter la location d'une voiture dans la liste location
    public static function reserverVoiture($utilisateur_id,$vehicule_id,$date_debut,$date_fin,$prix){
        try{
           $database=SModel::getInstance();
           $query="insert into table location values (:utilisateur_id,:vehicule_id,:date_debut2,:date_fin2,:prix)";
           $statement=$database->prepare($query);
           $statement->execute([
               'utilisateur_id'=>$utilisateur_id,
               'vehicule_id'=>$vehicule_id,
               'date_debut2'=>$date_debut,
               'date_fin2'=>$date_fin,
               'prix'=>$prix
           ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
        
    }
    public static function annulerReservation($vehiculeId,$utilisateurId,$dateDebut,$dateFin){
        try{
           $database=SModel::getInstance();
           $query="delete from table location where vehicule_id= :vehicule_id and utilisateur_id = :utilisateur_id and date_debut2= :date_debut2 and date_fin2=:date_fin2";
           $statement=$database->prepare($query);
           $statement->execute([
               'vehicule_id'=>$vehiculeId,
               'utilisateur_id'=>$utilisateurId,
               'date_debut2'=>$dateDebut,
               'date_fin2'=>$dateFin,
           ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    //recuperer la liste des sites contenant des vehicules louable en fonction de l'aeroport, des dates choisits
    public static function getListeSite($aeroport,$dateFin,$dateDebut){
        try{
         $liste= site::getListeSite($aeroport);
         foreach($liste as $key => $ele){
             if(location::getListeVehiculeLouable($ele->getId(),$dateDebut,$dateFin)==null){
                 unset($liste[$key]);
             }
         }
         if(sizeof($liste)==0){
             return null;
         }
         else{
             return $liste;
         }
         } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;  
         }
    }
    public static function getListeVehiculeLouable($siteId,$dateDebut,$dateFin){
        try{
           $database=SModel::getInstance();
           $query="select V.no_marque from Vehicule as V, gare as G,place as P where V.no_marque=G.vehicule_id
                   and P.id=G.place_id and P.site= :siteId and G.date_debut =< :dateDebut and G.date_fin >= :dateFin";
           $statement=$database->prepare($query);
           $statement->excute(['siteId'=>$siteId,'dateDebut'=>$dateDebut,'dateFin'=>$dateFin]);
           $listeVehicule=array();
           while($ligne = mysqli_fetch_array($statement,MYSQLI_NUM)){
               if(!Vehicule::estOccupe($ligne[0], $dateDebut, $dateFin)){
                   $listeVehicule[]= Vehicule::getVehiculeById($ligne[0]);
               }
           }
           if (size_of($listeVehicule)==0){
               return null;
           }
           else{
               return $listeVehicule;
           }
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;  
        }
    }
    public static function getElementsByIdUtilisateur($id){
        try{
            $database=SModel::getInstance();
          
            $query="select * from location where utilisateur_id=:utilisateur_id and date_fin > GETDATE()";
            $statement=$database->prepare($query);
            $statement->execute([
                'utilisateur_id'=>$id,
            ]);
            $listeLocation=$statement->fetchAll(PDO::FETCH_CLASS,"location");
            return $listeLocation;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function afficherLocation($id){
        try{
            $database=SModel::getInstance();
            $query="select L.vehicule_id, V.marque,V.modele, V.transmission, L.date_debut2, L.date_fin2, L.prix from vehicule.V, location.L where utilisateur_id=:id V.no_plaque=L.vehicule_id and date_fin2 > GETDATE()";
            $statement=$database->prepare($query);
            $statement->execute([
                'utilisateur_id'=>$id
            ]);
            $compteur=1;
            while($ligne = mysqli_fetch_array($statement,MYSQLI_NUM)){
              echo'<tr>';
              printf("<td>%d</td>",$compteur);
              printf("<td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%f</td>",$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6]);
              echo '<td>';
              echo "<form action='router.php?action=supprimerLocation' method='post'>";
              printf("<input type='hidden' name='vehiculeId' value='%s'>",$ligne[0]);
              printf("<input type='hidden' name='marque' value='%s'>",$ligne[1]);
              printf("<input type='hidden' name='modele' value='%s'>",$ligne[2]);
              printf("<input type='hidden' name='transmission' value='%d'>",$ligne[3]);
              printf("<input type='hidden' name='dateDebut' value='%s'>",$ligne[4]);
              printf("<input type='hidden' name='dateFin' vallue='%s'>,$ligne[5]");
              printf("<input type='hidden' name='prix' vallue='%f'>,$ligne[6]");
              echo"<input type='submit' value='supprimer'>";
              echo'</form>';
              echo'</td>';
              echo'</tr>';
            }
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
}

