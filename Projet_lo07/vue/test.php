<?php
require'../Fonction.php';
//$format = "%d-%B-%Y %H:%M ";
//$timestamp = time();
//echo $strTime = strftime($format, $timestamp );
//echo"\n";
echo getPrixReservation(2, $_GET['date1'], $_GET['date2']);
//if($timestamp < strtotime($_GET['date1'])){
//    echo "true";
//}
//else{
//    echo "false";
//}
//$today= getdate();
//echo $today;