<?php
require 'fragmentHeader.html';
require 'MenuUtilisateur.html';
//require'../modele/vehicule.php';
//require '../modele/place.php';
?>
<div class='container'>
    <div class="row">
        <div class='page-reservation'>
            <div class='tete-reservation'><h1>Choissiez une place à réserver</h1></div>
            <div class='parking-reservation'><img src='images.jpg' width="40px" height="40px"><h3>Parking</h3></div>
            <form method="get" action="router.php">
                <input type='hidden' name='action' value='choisirplace'>
                <div class='form-group'>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for='list-sites2'>Site</label>
                        <select id='list-sites2' class='form-control' disabled="disabled">.
                            <?php
                                printf("<option>".$_GET['list-sites']."</option>");
                            ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for='list-places'>Place</label>
                        <select id='list-places' class='form-control'>.
                             <option></option>
                            <?php
                            foreach ($listePlaces as $ele){
                                printf("<option>".$ele.getId()."</option>");
                            }
                            ?>
                        </select>
                    </div>
                     <div class='col-md-4'>
                        <label for='list-vehicules2'>Vehicule</label>
                        <select id='list-vehicules2' class='form-control' disabled='disabled'>
                            <?php
                                printf("<option>".$_GET('list-vehicule')."</option>");
                            ?>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label for='date1' >Date de début</label>
                        <?php
                        printf("<input class='form-control' type='text' name='datedebut' value='%s' disabled='disabled'>",$_GET['datedebut']);
                        ?>
                    </div>
                    <div class='col-md-2'>
                        <label for='date2'>Date de fin</label>
                        <?php
                        printf("<input class='form-control' type='text' name='datefin' value='%s' disabled='disabled'>",$_GET['datefin']);
                        ?>
                    </div>

                </div>
                <div class="clearfix"></div>
                <br>
                <table class='table table-bordered' style="width:400px">
                    <tr>
                        <td>Temps total:</td>
                        <?php
                        //calculer le temnp
                        ?>
                    </tr>
                    <tr>
                        <td>Prix total:</td>
                        <?php
                        //calculer le prix
                        ?>
                    </tr>
                </table>
                <hr>
                <input class='btn btn-default' type='submit' value='Valider la reservation'>



            </form>
        </div>
    </div>
</div>




<?php require 'fragmentFooter.html';?>