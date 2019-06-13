<?php
class site {
    private $id, $label, $aeroport,$adresse,$nombre_place,$prix_jour;
    public function __contruct($id=null,$label=null,$aeroport=null,$adresse=NULL,$nombrePlace=null,$prixJour=null){
        if(!is_null($id)){
            $this->id=$id;
            $this->label=$label;
            $this->aeroport=$aeroport;
            $this->nombre_place=$nombrePlace;
            $this->prix_jour=$prixJour;
            $this->adresse=$adresse; 
        }
    }
    function setId($id) {
        $this->id = $id;
    }
    function setlabel($label) {
        $this->label = $label;
    }
    function setAeroport($aeroport) {
        $this->aeroport = $aeroport;
    }
    function setNombrePlace($nombrePlace) {
        $this->nombre_place = $nombrePlace;
    }
    function setPrixJour($prixJour){
        $this->prix_jour=$prixJour;
    }
    function getId() {
        return $this->id;
    }

    function getLabel() {
        return $this->label;
    }

    function getAeroport() {
        return $this->aeroport;
    }

    function getNombrePlace() {
        return $this->nombre_place;
    }
     function getPrixJour() {
        return $this->prix_jour;
    }   
    public function toString(){
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%d</td><td>%f</td></tr>", 
        $this->getId(), $this->getLabel(), $this->getAeroport(), $this->getNombrePlace(), $this->getPrixJour());
    }
    public static function ajouterSite($id, $label, $aeroport,$adresse,$nombrePlace,$prixJour){
        try{
            $database = SModel::getInstance();
            $query = "insert into site values (:id, :label, :aeroport,:adresse, :nombrePlace, :prixJour)";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id,
                'label' => $label,
                'aeroport' => $aeroport,
                'adresse'=>$adresse,
                'nombrePlace' => $nombrePlace,
                'prixJour'=>$prixJour
            ]);
            return true;   
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    //calculer le nombre de places disponible des sites correspondant a l'aeroport choisit
    public static function mettreAJourNombrePlace($id,$dateDebut,$dateFin){
        try{
            require_once './modele/place.php';
            $database = SModel::getInstance();
            $query = "select * from place where site_id = :id ";
            $statement = $database->prepare($query);
            $statement->execute(['id'=>$id]);
            $listePlace = $statement->fetchAll(PDO::FETCH_CLASS, "place");
            $compteur=0;
            foreach ($listePlace as $place){
                if(!place::estOccupe($place->getId(),$id,$dateDebut,$dateFin)){
                    $compteur++;
                }
            }
            $requet="UPDATE site SET nombre_place = :compteur where id= :id";
            $statement2 = $database->prepare($requet);
            $statement2->execute(['compteur'=>$compteur,'id'=>$id]);
            return true;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    //donner la liste de sites correspondant a l'aeroport
    public static function getListeSite($aeroport){
        try {
            $database = SModel::getInstance();
            $query = "select * from site where aeroport= :aeroport ";
            $statement = $database->prepare($query);
            $statement->execute(['aeroport'=>$aeroport]);
            $liste_Site=$statement->fetchAll(PDO::FETCH_CLASS, "site");
            return $liste_Site;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function getSiteById($id){
          $database = SModel::getInstance();
          $query = "select * from site where id = :id";
          $statement = $database->prepare($query);
          $statement->execute(['id'=>$id]);
          $site=$statement->fetchAll(PDO::FETCH_CLASS,"site");
          if(sizeof($site)==0){
              return NULL;
          }
          return $site[0];
      }
    
}
