<?php 
require 'fragmentHeader.html';
require 'menuUtilisateur.html';
//require_once './modele/utilisateur.php';
//require'./modele/gare.php'
?>
<h1><img src='./vue/espaceClient.png' style="width: 100px;height: 100px">Ajouter une véhicule</h1>
<hr>
<div id="ajouteVehicule" class="row">
    <div class="col-md-3">
         <form id='form-ajoute1' style='margin-left:2%' id='form-vehicule' method="get" action="router.php?">
           <input type='hidden' name='action' value="validerAjouteVehicule">
           <label for="no-plaque">Numéro de plaque du véhicule à ajouter:</label>
           <input type='text' class='form-control' name='no-plaque' id='no-plaque'>
            
         </form>
    </div>
    <hr>
</div>
<div style='margin-left:2%' id="creer-vehicule" class="row">
    <div class="col-md-5">
        <form id='form-ajoute2' id='form-vehicule' method="get" action="router.php?">
           <input type='hidden' name='creer' value="creervehicule">
           <input type='hidden' name='action' value="validerAjouteVehicule">
           <label for="noplaque2">Numéro de plaque</label>
           <input type='text' class='form-control' name='no-plaque' id="noplaque2" >
           <label id="a" for="marque2">Marque</label>
           <input type='text' class='form-control' name='marque' id='marque2'>
           <label for="modele2">Modèle</label>
           <input type='text' class='form-control' name='modele' id='modele2' >
           <label for="transmission2">Transmission</label>
           <input type='text' class='form-control' name='transmission' id='transmission2'>
           <label for="prix2">Prix</label>
           <input type='text' class='form-control' name='prix' id='prix2'>
        </form>
       <!--<button type="button" class="btn btn-danger" id='annuler' onclick="annuler('modificationMotDePasse')">Annuler</button>-->
    </div>
</div>
<button class="btn btn-default" style='outline: none' type="button" onclick="validerAjoute()">Valider</button>
<button class="btn btn-default" style='outline: none' type="button" onclick='ouvrir()' id='button-creer'>Créer un véhicule</button>
<script>
//       $('#b').val()=x
       var x = document.getElementById('creer-vehicule');
       var y= document.getElementById('button-creer');
       function ouvrir(){
           if (y.innerText=='Créer un véhicule'){
                x.style.display="block"
                y.innerHTML="Annuler la création";
           }
           else if (y.innerText=='Annuler la création'){
                x.style.display="none"
                y.innerHTML="Créer un véhicule";
           }
       }
       function validerAjoute(){
            if($('#no-plaque').val()==''){
                alert("FORMULAIRE INCOMPLET!");
            }
            else{
                if(y.innerText=="Créer un véhicule"){
                    $('#form-ajoute1').submit()
                }
                else if(y.innerText=="Annuler la création"){
                    if($('#noplaque2').val()==''||$('#marque2').val()==''||$('#modele2').val()==''||$('#transmission2').val()==''||$('#prix2').val()==''){
                        alert('FORMULAIRE INCOMPLET!');
                    }
                    else if($('#noplaque2').val()!=$('#no-plaque').val()){
                        alert('Numéro de plaque incoresspondant!');
                    }
                    else{
                        $('#form-ajoute2').submit();
                    }
                }
            }
       }
//    function valider(){
//        if($('#noPlaque').val()==''||$('#marque').val()==''||$('#modele').val()==''||$('#transmission').val()==''||$('#prix').val()==''){
//            alert("FORMULAIRE INCOMPLET!!");
//        }
//        else{
//            $('#form-vehicule').submit();
//        }
//    }

</script>
<?php require 'fragmentFooter.html';?>
