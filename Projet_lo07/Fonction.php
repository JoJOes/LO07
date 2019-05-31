<?php
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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

