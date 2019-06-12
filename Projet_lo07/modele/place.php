<?php

class place {
    private $id, $site;
    public function __contruct($id=null, $site=null){
        if(!is_null($id)){
            $this->id=$id;
            $this->site=$site;
        }
    }
    function setId($id) {
        $this->id = $id;
    }

    function setSite($site) {
        $this->site = $site;
    }
     function getId() {
        return $this->id;
    }

    function getSite() {
        return $this->site;
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
            $database = SModel::getInstance();
            $query = "select * from gare where place_id = :id and site_id=:siteId )";
            $statement = $database->prepare($query);
            $statement->execute(['place_id'=>$id,'siteId'=>$siteId]);
            $listeGare=$statement->fetchAll(PDO::FETCH_CLASS,"gare");
            $occupe=false;
            foreach($listeGare as $gare){
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
    public static function getListePlaceDisponible($siteId){
        try{
            $database = SModel::getInstance();
            $query = "select * from place where site = :siteId )";
            $statement = $database->prepare($query);
            $statement->execute(['siteId'=>$siteId]);
            $listePlace=$statement->fetchAll(PDO::FETCH_CLASS,"place");
            $listePlaceDisponible=array();
            foreach($listePlace as $place){
                if(!place::estOccupe($place->getId(),$place->getDateDebut(),$place->getDateFin())){
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