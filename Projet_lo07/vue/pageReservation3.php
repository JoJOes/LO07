<?php
require 'fragmentHeader.html';
require 'MenuUtilisateur.html';
//require'../modele/vehicule.php';
require_once './modele/place.php';
//require './Fonction.php';
//leverErreur($message);
?>
<div class='container'>
    <div class="row">
        <div class='page-reservation'>
            <div class='tete-reservation'><h1>Choissiez une place à réserver</h1></div>
            <div class='parking-reservation'><img src='./vue/images.jpg' width="40px" height="40px"><h3>Parking</h3></div>
            <form method="get" action="router.php">
                <input type='hidden' name='action' value='validerReservation'>
                <div class='form-group'>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for='list-sites2'>Site</label>
                        <select id='list-sites2' class='form-control' disabled="disabled">.
                            <?php
                                printf("<option>".$site->getLabel()."</option>");
                                printf("<input type='hidden' name='site_id' value='%s'>",$site->getId());
                            ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for='list-places'>Place</label>
                        <select id='list-places' name='list-places' class='form-control'>.
                             <option></option>
                            <?php
                            foreach ($listePlaces as $ele){
                                printf("<option value='%d'>".$ele."</option>",$ele);
                            }
                            ?>
                        </select>
                    </div>
                     <div class='col-md-4'>
                        <label for='list-vehicules2'>Vehicule</label>
                        <select id='list-vehicules2' class='form-control' disabled='disabled'>
                            <?php
//                                printf("<option>".$_GET('list-vehicules')."</option>");
                                printf("<option>".$_GET['list-vehicules']."</option>");
                                printf("<input type='hidden' name='vehicule_id' value='%s'>",$_GET['list-vehicules']);
                            ?>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label for='date1' >Date de début</label>
                        <?php
                        printf("<input class='form-control' type='text' value='%s' disabled='disabled'>",$_GET['datedebut']);
                        printf("<input type='hidden' name='datedebut' value='%s'>",$_GET['datedebut']);
                        ?>
                    </div>
                    <div class='col-md-2'>
                        <label for='date2'>Date de fin</label>
                        <?php
                        printf("<input class='form-control' type='text' value='%s' disabled='disabled'>",$_GET['datefin']);
                        printf("<input type='hidden' name='datefin' value='%s'>",$_GET['datefin']);
                        ?>
                    </div>

                </div>
                <div class="clearfix"></div>
                <br>
                <table class='table table-bordered' style="width:400px">
                    <tr>
                        <td>Temps total:</td>
                        <?php
                        printf("<td>%d</td>",$tempsTotal);
                        ?>
                    </tr>
                    <tr>
                        <td>Prix total:</td>
                        <?php
                        printf("<td>%.2f euro</td>",$tempsTotal*$prix);
                        printf("<input type='hidden' name='prix' value='%.2f'>",$tempsTotal*$prix);
                        ?>
                    </tr>
                </table>
                <hr>
                <input class='btn btn-default' type='button' onclick="verifier()" value='Valider la reservation'>


            </form>
        </div>
    </div>
</div>
<script>
//    $('button').onclick(verifier);
    function verifier(){
        if($('#list-places').val()==''){
            alert('FORMULAIRE INCOMPLET!')
        }else{
            $('form').submit();
        }
    }
</script>



<?php require 'fragmentFooter.html';?>