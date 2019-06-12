<?php
class site {
    private $id, $label, $aeroport,$nombrePlace,$prixJour;
    public function __contruct($id=null,$label=null,$aeroport=null,$nombrePlace=null,$prixJour=null){
        if(!is_null($id)){
            $this->id=$id;
            $this->label=$label;
            $this->aeroport=$aeroport;
            $this->nombrePlace=$nombrePlace;
            $this->prixJour=$prixJour;
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
        $this->nombrePlace = $nombrePlace;
    }
    function setPrixJour($prixJour){
        $this->prixJour=$prixJour;
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
        return $this->nombrePlace;
    }
     function getPrixJour() {
        return $this->prixJour;
    }
    public function toString(){
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%d</td><td>%f</td></tr>", 
        $this->getId(), $this->getLabel(), $this->getAeroport(), $this->getNombrePlace(), $this->getPrixJour());
    }
    public static function ajouterSite($id, $label, $aeroport,$nombrePlace,$prixJour){
        try{
            $database = SModel::getInstance();
            $query = "insert into site values (:id, :label, :aeroport, :nombrePlace, :prixJour)";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id,
                'label' => $label,
                'aeroport' => $aeroport,
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
            $database = SModel::getInstance();
            $query = "select * from place where site = :id ";
            $statement = $database->prepare($query);
            $statement->execute(['id'=>$id]);
            $listePlace = $statement->fetchAll(PDO::FETCH_CLASS, "place");
            $compteur=0;
            foreach ($listePlace as $place){
                if(!place::estOccuppe($place->getId(),$dateDebut,$dateFin)){
                    $compteur++;
                }
            }
            $requet="UPDATE Site SET nombre_place = :compteur where id= :id";
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
            $query = "select * from Site where aeroport= :aeroport ";
            $statement = $database->prepare($query);
            $statement->execute(['aeroport'=>$aeroport]);
            $liste_Site=$statement->fetchAll(PDO::FETCH_CLASS, "site");
            return $liste_Site;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    
    
}
