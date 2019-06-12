<?php
require_once 'modele/SModel.php';
function betweenDates($date1,$dateDebut, $dateFin){
   if($date1>= $dateDebut &&  $date1<=dateFin){
       return 0;
   }
   return 1;
}
function dateUtilisable($date1,$date2,$dateDebut, $dateFin){
    if($date1<$date2 && ($date2<$dateDebut || $date1>$dateFin )){
        return TRUE;
    }
    return FALSE;
}
function getListeAeroports(){
    try{
        $database=SModel::getInstance();
        $query="select nom form aeroport";
        $statement = $database->prepare($query);
        $statement->execute();
        $listeAeroport=array();
        while($ligne = mysqli_fetch_array($statement,MYSQLI_NUM)){
            $listeAeroport[]=$ligne;
        }
       return $listeAeroport;
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;  
    }
  
}
$today= getdate();
echo strtotime($today);
//
 $another="2019-06-10 22:39:16";
//   if ($today < strtotime($another)){
//       echo"true";
//   }
//   else{
//       echo"false";
//   }

$format = "%H:%M:%S %d-%B-%Y";
$timestamp = time();
echo $strTime = strftime($format, $timestamp );
echo  "<br />";
echo "Timestamp:" . $timestamp;
if ($timestamp < strtotime($another)){
       echo"true";
   }
   else{
       echo"false";
   }

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

