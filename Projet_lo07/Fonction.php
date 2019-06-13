
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
        $query="select nom from aeroport";
//        $statement = $database->query($query);
        $statement=$database->prepare($query);
        $statement->execute();
        $listeAeroport=array();
//        $statement->setFetchMode(PDO::FETCH_ASSOC);
        while($ligne = $statement->fetch()){
            $listeAeroport[]=$ligne[0];
        }
       return $listeAeroport;
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;
    }

}

//function getPrixReservation($prix, $dateDebut, $dateFin) {
//    $dateDebutFormat = new DateTime($dateDebut, new DateTimeZone('Pacific/Nauru'));
//    $dateFinFormat = new DateTime($dateFin, new DateTimeZone('Pacific/Nauru'));
//
//    $diff = $dateDebutFormat->diff($dateFinFormat);
//    $diffHeures = $diff->h + $diff->d*24;
//    $diffMinutes = $diff->i;
//
//    if ($diffMinutes > 0) {
//        $diffHeures++;
//    }
//    return $diffHeures*$prix;
//}
function getTemps($dateDebut,$dateFin){
    $dateDebutFormat = new DateTime($dateDebut, new DateTimeZone('Pacific/Nauru'));
    $dateFinFormat = new DateTime($dateFin, new DateTimeZone('Pacific/Nauru'));

    $diff = $dateDebutFormat->diff($dateFinFormat);
    $diffHeures = $diff->h + $diff->d*24;
    $diffMinutes = $diff->i;

    if ($diffMinutes > 0) {
        $diffHeures++;
    }
    return $diffHeures;
}
//function leverErreur($message){
//    if($message!=NULL){
//        printf("<div class='text-center' style='color:red'>%s</div>",$message);
//    }
//}
//$today= getdate();
////echo strtotime($today);
////
//// $another="2019-06-10 22:39:16";
////   if ($today < strtotime($another)){
////       echo"true";
////   }
////   else{
////       echo"false";
////   }
//
//$format = "%H:%M:%S %d-%B-%Y";
//$timestamp = time();
//echo $strTime = strftime($format, $timestamp );
//echo  "<br />";
//echo "Timestamp:" . $timestamp;
//if ($timestamp < strtotime($another)){
//       echo"true";
//   }
//   else{
//       echo"false";
//   }
//
///*
// * To change this license header, choose License Headers in Project Properties.
// * To change this template file, choose Tools | Templates
// * and open the template in the editor.
// */
