<?php
require 'fragmentHeader.html';
require 'MenuUtilisateur.html';
//require'../modele/vehicule.php'
//require '../Fonction.php';
//leverErreur($message);
?>
<div class='container'>
    <div class="row">
        <div class='page-reservation'>
            <div class='tete-reservation'><h1>Choissiez une place à réserver</h1></div>
            <div class='parking-reservation'><img src='./vue/images.jpg' width="40px" height="40px"><h3>Parking</h3></div>
            <form method="GET" action="router.php">
                <input type='hidden' name='action' value='reservation3'>
                <?php
                    printf("<input type='hidden' name='list-aeroport' value='%s'>",$_GET['list-aeroport']);
                    ?>
                <div class='form-group'>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <label for='list-sites'>Site</label>
                        <select id='list-sites' name='list-sites' class='form-control'>.
                             <option></option>
                            <?php
                                foreach ($listeSites as $ele){
                                    printf("<option value='".$ele->getId()."'>".$ele->getLabel().", prix/jour: %.2f, nb de places: %d</option>",$ele->getPrixJour(),$ele->getNombrePlace());
                                }
                                ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                         <div class='form-vehicule'>
                            <label for='list-vehicules'>Vehicule</label>
                            <select id='list-vehicules' name='list-vehicules' class='form-control'>.
                                 <option></option>
                                <?php
                                foreach ($listeVehicules as $ele){
                                    printf("<option value='".$ele->getNoPlaque()."'>%s, %s</option>",$ele->getMarque(),$ele->getNoPlaque());
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class='form-date'>
                            <label for='date1' >Date de début</label>
                            <?php
                            printf("<input class='form-control' type='text' value='%s' disabled='disabled' >",$date1);
                            printf("<input type='hidden' name='datedebut' value='%s'>",$date1);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class='form-date'>
                            <label for='date2'>Date de fin</label>
                            <?php
                            printf("<input class='form-control' type='text' disabled='diasabled' value='%s' >",$date2);
                            printf("<input type='hidden' name='datefin' value='%s'>",$date2);
                            ?>
                        </div>
                    </div>
                </div>
                <input class='btn btn-default'  type='button' name='' onclick='verifier()' value='Continuer'>
                <!--<div class="col-md-5"></div>-->
            </form>
        </div>
    </div>
</div>
<script>
//    $('button').onclick(verifier);
    function verifier(){
        if($('#list-sites').val()==''||$('#list-vehicules').val()==''){
            alert('FORMULAIRE INCOMPLET!')
        }else{
            $('form').submit();
        }
    }
</script>




<?php require 'fragmentFooter.html';?>