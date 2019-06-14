<?php

class place {
    private $id, $site_id;
    public function __contruct($id=null, $site=null){
        if(!is_null($id)){
            $this->id=$id;
            $this->site_id=$site;
        }
    }
    function setId($id) {
        $this->id = $id;
    }

    function setSite($site) {
        $this->site_id = $site;
    }
     function getId() {
        return $this->id;
    }

    function getSite() {
        return $this->site_id;
    }
    public function toString(){
        printf("<tr><td>%d</td><td>%s</td></tr>", 
        $this->getId(), $this->getSite());
    }
    public static function ajouterPlace($id,$site){
        try{
            $database = SModel::getInstance();
            $query = "insert into table place values(:id,:site)";
            $statement = $database->prepare($query);
            $statement->execute(['id'=>$id,'site'=>$site]);
            return true;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
    public static function estOccupe($id,$siteId,$dateDebut,$dateFin){
        try{
            require_once'./modele/gare.php';
            $database = SModel::getInstance();
            $query = "select * from gare where place_id = :place_id and site_id=:siteId and date_fin>:dateDebut and date_debut<:dateFin ";
            $statement = $database->prepare($query);
            $statement->execute(['place_id'=>$id,'siteId'=>$siteId,'dateDebut'=>$dateDebut,'dateFin'=>$dateFin]);
            $listeGare=$statement->fetchAll(PDO::FETCH_CLASS,"gare");
            if(sizeof($listeGare)==0){
                return false;
            }
            else{
                return true;
            }
            } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }
    public static function getListePlaceDisponible($siteId,$dateDebut,$dateFin){
        try{
            $database = SModel::getInstance();
            $query = "select * from place where site_id = :siteId";
            $statement = $database->prepare($query);
            $statement->execute(['siteId'=>$siteId]);
            $listePlace=$statement->fetchAll(PDO::FETCH_CLASS,"place");
            $listePlaceDisponible=array();
            foreach($listePlace as $place){
                if(place::estOccupe($place->getId(),$siteId,$dateDebut,$dateFin)==false){
                    $listePlaceDisponible[]=$place->getId();
                }
            }
            return $listePlaceDisponible;
         } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;  
         }
    }
    
            
}