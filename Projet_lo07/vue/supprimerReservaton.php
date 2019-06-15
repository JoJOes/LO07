<?php 
require 'fragmentHeader.html';
require 'menuUtilisateur.html';
//require_once './modele/utilisateur.php';
//require'./modele/gare.php'
?>
<h1><img src='./vue/espaceClient.png' style="width: 100px;height: 100px">Modification du véhicule</h1>
<hr>
<div id="modificationVehicule" class="row">
    <div class="col-md-5">
        <form id='form-vehicule' method="get" action="router.php?">
           <input type='hidden' name='action' value="validerModificationVehicule">
<!--           <label id="label-noplaque" for="noPlaque">Numéro de plaque</label>
           <input type='text' class='form-control' name='noPlaque2' id='no-plaque'>-->
           <?php
           printf("<input type='hidden' name='noPlaque' value='%s'>",$vehicule->getNoPlaque())
           ?>
           <label id="a" for="marque">Marque</label>
           <?php
           printf("<input type='text' class='form-control' name='marque' id='marque' value='%s'>",$vehicule->getMarque());
           ?>
           <label for="modele">Modèle</label>
           <?php
           printf("<input type='text' class='form-control' name='modele' id='modele' value='%s'>",$vehicule->getModele());
            ?>
           <label for="transmissiontra">Transmission</label>
           <?php
           if($vehicule->getTranmission()==0){
               $b='non';
           }
           else{
               $b='oui';
           }
           printf("<input type='text' class='form-control' name='transmission' id='transmission' value='%s'>",$b);
           ?>
           <label for="prix">Prix</label>
           <?php
           printf("<input type='text' class='form-control' name='prix' id='prix' value='%d'>",$vehicule->getPrix());
            ?>
        </form>
        <button type="button" class="btn btn-primary" onclick="valider()">Valider</button>
       <!--<button type="button" class="btn btn-danger" id='annuler' onclick="annuler('modificationMotDePasse')">Annuler</button>-->
    </div>
</div>
<script>
    
    function valider(){
        if($('#noPlaque').val()==''||$('#marque').val()==''||$('#modele').val()==''||$('#transmission').val()==''||$('#prix').val()==''){
            alert("FORMULAIRE INCOMPLET!!");
        }
        else{
            $('#form-vehicule').submit();
        }
    }

</script>
<?php require 'fragmentFooter.html';?>
