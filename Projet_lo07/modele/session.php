<?php
class session{
    private $session_id;
    public function __contruct($session = null){
        $this->session_id=$session;
    }
    public static function VerifierAuthentification($id){
        try {
            if($_SESSION[$id]!=null){
                return TRUE;
            }
            return FALSE;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
    public static function ajouterSession($id){
        try {
            session_start();
            $_SESSION[$id]=$id;
            return true;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
    public static function supprimmerSession($id){
        try{
            unset($_SESSION['$id']);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }    
    }
}