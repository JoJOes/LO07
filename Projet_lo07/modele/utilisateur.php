<?php

require_once 'SModel.php';

class ModeleUtilisateur {
    private $id, $login, $nom, $prenom, $motDePasse, $admin;

    public function __construct($id = NULL, $login = NULL, $nom = NULL, $prenom = NULL, $motDePasse = NULL, $admin = 0) {
        // valeurs nulles si pas de passage de parametres
        if (!is_null($id)) {
            $this->id = $id;
            $this->login = $login;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->motDePasse = $motDePasse;
            $this->admin = $admin;
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }

    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->login;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getMotDePasse() {
        return $this->motDePasse;
    }

    function getAdmin() {
        return $this->admin;
    }

    public function __toString() {
        return $this->id;
    }

    public static function insert($login, $nom, $prenom, $motDePasse) {
        try {
            $database = SModel::getInstance();
            $query = "INSERT INTO utilisateur VALUES (:login, :nom, :prenom, :motDePasse)";
            $statement = $database->prepare($query);
            $statement->execute([
                'login' => $login,
                'nom' => $nom,
                'prenom' => $prenom,
                'motDePasse' => $motDePasse
            ]);
            return TRUE;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }
    }
    public static function voirProfil($id){
        try{
            $database = SModel::getInstance();
            $query = "select * from utilisateur where id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id              
            ]);
            $utilisateur=$statement->fetchAll(PDO::FETCH_CLASS,"utilisateur");
            return $utilisateur[0];
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }
    }
    public static function getVehicules($id){
        try{
            $database = SModel::getInstance();
            $query = "select * from possession where utilisateur_id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id              
            ]);
            $possession=$statement->fetchAll(PDO::FETCH_CLASS,"possession");
            $vehicules=array();
            foreach($possession as $ele){
                $vehicules[]=Vehicule::getVehiculeById($ele->getVehiculeId());
                
            }
            return $vehicules;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }
    }
    public static function modifierNomPrenom($id,$nom,$prenom){
        try{
            $database = SModel::getInstance();
            $query = "UPDATE utilisateur SET nom=:nom and prenom=:prenom where id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id,
                'nom'=>$nom,
                'prenom'=>$prenom
            ]);
            return true;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }
    }
    public static function modifierMotDePasse($id,$motDePasse){
        try{
            $database = SModel::getInstance();
            $query = "UPDATE utilisateur SET mot_de_passe=:motDePasse where id=:id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id,
                'motDePasse'=>$motDePasse
            ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }
    }
    public static function ajouterVehicule($id,$noPlaque, $marque,$modele,$transmission,$prix,$carburant){
        try{
            $database = SModel::getInstance();
            $query = "select * from vehicule where no_plaque = :noPlaque";
            $statement = $database->prepare($query);
            $statement->execute([
                'no_plaque'=>$noPlaque
            ]);
            if($statement==null){
                Vehicule::insert($noPlaque, $marque, $modele, $transmission, $prix, $carburant);
            }
            $requet="insert into table possession values (:utilisateur_id,:vehicule_id)";
            $statement2 = $database->prepare($requet);
            $statement2->execute([
                'utilisateur_id' => $id,
                'vehicule_id'=>$noPlaque
            ]);
            return TRUE;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }    
    }
    public static function supprimmerVehicule($id,$noPlaque){
        try{
            $database = SModel::getInstance();
            $query = "delete from possession where utilisateur_id=:id and vehicule_id=:noPlaque";
            $statement = $database->prepare($query);
            $statement->execute([
                'vehicule_id'=>$noPlaque,
                'utilisateur_id'=>$id
            ]);
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return FALSE;
        }    
    }
    public static function VerifierAuthentification($id){
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
    }
    public static function garerVehicule($id){
        
    }
    
}
