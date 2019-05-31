<?php
class session{
    private $session_id;
    public function __contruct($session = null){
        $this->session_id=$session;
    }
    public static function VerifierAuthentification($id){
        try {
            $database = SModel::getInstance();
            $query = "select session_id from session where session_id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id'=>$id
            ]);
            $liste=$statement->fetchAll(PDO::FETCH_CLASS,"possession");
            if(sizeof($liste)==0){
                return false;
            }
            return TRUE;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
    public static function ajouterSession($id){
        try {
            $database = SModel::getInstance();
            $query = "insert into table session values(:id)";
            $statement = $database->prepare($query);
            $statement->execute([
                'id'=>$id
            ]);
            return TRUE;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
    public static function supprimmerSession($id){
        try{
            $database = SModel::getInstance();
            $query = "delete from session where session_id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id'=>$id
            ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
}