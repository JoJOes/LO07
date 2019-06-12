<?php
require 'fragmentHeader.html';
require 'MenuUtilisateur.html';
//require'../modele/vehicule.php'
require '../Fonction.php';
leverErreur($message);
?>
<div class='container'>
    <div class="row">
        <div class='page-reservation'>
            <div class='tete-reservation'><h1>Choissiez une place à réserver</h1></div>
            <div class='parking-reservation'><img src='images.jpg' width="40px" height="40px"><h3>Parking</h3></div>
            <form method="get" action="router.php?action=reservation3">
                <input type='hidden' name='action' value='choisirplace'>
                <div class='form-group'>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for='list-sites'>Site</label>
                        <select id='list-sites' name='list-sites' class='form-control'>.
                             <option></option>
                            <?php
                                foreach ($listeSites as $ele){
                                    printf("<option>".$ele.getNom().", prix/Jour: ".$ele.getPrixJour()."</option>");
                                }
                                ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                         <div class='form-vehicule'>
                            <label for='list-vehicules'>Vehicule</label>
                            <select id='list-vehicules' name='list-vehicules' class='form-control'>.
                                 <option></option>
                                <?php
                                foreach ($listeVehicules as $ele){
                                    printf("<option>".$ele.getNoPlaque().",".$ele.getMarque()."</option>");
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class='form-date'>
                            <label for='date1' >Date de début</label>
                            //<?php
//                            printf("<input class='form-control' type='text' name='datedebut' value='%s' disabled='disabled'>",$_GET['date1']);
//                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class='form-date'>
                            <label for='date2'>Date de fin</label>
                            //<?php
//                            printf("<input class='form-control' type='text' name='datefin' value='%s' disabled='disabled'>",$_GET['date2']);
//                            ?>
                        </div>
                    </div>
                </div>

                
                <input class='btn btn-default' type='submit' value='choisir une place'>
                <div class="clearfix"></div>


            </form>
        </div>
    </div>
</div>




<?php require 'fragmentFooter.html';?>