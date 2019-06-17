<?php 
require 'fragmentHeader.html';
require 'menuUtilisateur.html';
//require_once './modele/utilisateur.php';
require_once'./modele/gare.php'
?>
<h1><img src='./vue/espaceClient.png' style="width: 100px;height: 100px"> Espace personnelle</h1>
<div class="tab">
    <button class="tablink" id='info' onclick="ouvrirFenetre(event,'mesinfos')">Mes informations</button>
    <button class="tablink" id='vehicule' onclick="ouvrirFenetre(event,'mesvehicules')">Mes Vehicules</button>
    <button class="tablink" id='reservation' onclick="ouvrirFenetre(event,'mesreservation')">Mes reservations</button>
</div>

<!--<script>$('#info').click()</script>-->
<div id="mesinfos"class="tabcontent" >
   
    <table class='table table-bordered' style='border-color: #4d4d4d;width: 200px'>
                <tr><th class='text-center' colspan="2">Mes informations</th></tr>
                <tr>
                    <th>Nom</th>
                     <?php
                        printf("<td id='nom2'>%s</td>",$utilisateur->getNom());
                     ?>
                </tr>
                <tr>
                    <th>Prenom</th>
                     <?php
                        printf("<td id='prenom2'>%s</td>",$utilisateur->getPrenom());
                     ?>
                </tr>
                <tr>
                    <th>Admin</th>
                     <?php
                        if($utilisateur->getAdmin()==0){
                            printf("<td>non</td>");
                        }
                        else{
                            printf("<td>oui</td>");
                        }
                        
                     ?>
                </tr>
    </table>
<!--    <form action='router.php' method="get">
         <button type='submit' class="btn btn-primary">Modifier mes informations</button><input type='hidden' id='action' value="modifierInformation">
        <button type='submit' class="btn btn-primary">Modifier mes informations</button>
    </form>-->
    <button type='button' onclick='modifierInformation()' class="btn btn-primary">Modifier mes informations</button>
    <button type='button' onclick='modifierMotDePasse()' class="btn btn-primary">Modifier le mot de passe</button>
    <hr>
    <div id="modificationInformation" class="row">
        <div class="col-md-4">
            <form id='form-info' method="get" action="router.php">
                <input type='hidden' name='action' value="validerModificationInformation">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom">
                <label for="nom">Prenom</label>
                <input type="text" class="form-control" name="prenom" id="prenom">
                </br>
            </form>
            <button type="button" id='validerInfo' class="btn btn-primary">Valider</button>
            <button type="button" class="btn btn-danger" id='annuler' onclick="annuler('modificationInformation')">Annuler</button>
        </div>
    </div>
    <div id="modificationMotDePasse" class="row">
        <div class="col-md-4">
            <form id='form-mot-de-passe' method="post" action="router.php?action=validerModificationMotDePasse">
               <!--<input type='hidden' name='action' value="validerModificationMotDePasse">-->
               <label for="motdepasse">Mot de Passe</label>
               <input type="password" class="form-control" name="motdepasse" id="motdepasse">
               <label for="motdepasse">Ressaisir le mot de Passe</label>
               <input type="password" class="form-control" id="remotdepasse">
            </form>
           <button type="button" id='validerMotDePasse' class="btn btn-primary">Valider</button>
           <button type="button" class="btn btn-danger" id='annuler' onclick="annuler('modificationMotDePasse')">Annuler</button>
        </div>
    </div>
    <!--<button type="button" class="btn btn-danger" id='annuler' onclick='annuler()'>Annuler</button>-->
</div>
<div class="tabcontent" id="mesvehicules">
    <table class="table table-bordered">
        <tr><th class='text-center' colspan="7">Vos vehicules</th></tr>

        <tr>
            <th>Nummero de plaque</th>
            <th>Marque</th>
            <th>Modele</th>
            <th>Transmission</th>
            <th>Prix par heure</th>
            <th colspan="2"></th>
        </tr>
            <?php 
                foreach ($listeVehicules as $ele){
                    echo'<tr>';
                    $ele->toString();
                    echo"<td>";
                    echo "<form action='router.php' method='get'>";
                    printf("<input type='hidden' name='action' value='modifierVehicule'>");
                    printf("<input type='hidden' name='noplaque' value='%s'>",$ele->getNoPlaque());
                    echo"<input class='btn btn-primary' type='submit' value='Modifier'>";
                    echo'</form>';
                    echo'</td>';
                    echo "<td>";
                    echo "<form action='router.php' method='get'>";
                    printf("<input type='hidden' name='action' value='supprimerVehicule'>");
                    printf("<input type='hidden' name='noplaque' value='%s'>",$ele->getNoPlaque());
                    echo"<input class='btn btn-danger' type='submit' value='supprimer'>";
                    echo'</form>';
                    echo '</td>';
                    echo'</tr>';
                }
            ?>
    </table>
    
    <form action='router.php?action=ajouterVehicule' method="get">
            <input type='hidden' name='action' value="ajouterVehicule">
            <button type='submit' class="btn btn-primary">Ajouter une véhicule</button>
    </form>  
    <hr>

</div>
<div class="tabcontent" id="mesreservation">
    <div class="row">
        <div class  ="col-md-12">
            <table class='table table-bordered' title="Les places reservees">
                <tr>
                    <th>Numéro</th>
                    <th>Numéro de plaque du véhicule</th>
                    <th>Numéro de place</th>
                    <th>Label du site</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Prix</th>
                    <th></th>
                </tr>
                <?php
                    Gare::afficherReservation($id)
                ?>
            </table>
        </div>
    </div>
</div>
<script>
    function supprimerReservation(id,prix){
        if(confirm('Vous voulez supprimer la resservation avec le prix rembourse de 50%: '+prix/2)==true){
            document.getElementById(id).submit();
        }
    }
    function ouvrirFenetre(evt, contenu){
        var i, tabcontents, tablinks;
        tabcontents=document.getElementsByClassName('tabcontent');
        for (i = 0; i < tabcontents.length; i++) {
            tabcontents[i].style.display = "none";
        }
            tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active", "");
        }
        document.getElementById(contenu).style.display = "block";
            evt.currentTarget.className += " active";
    }
    function modifierInformation(){
        document.getElementById('nom').value=document.getElementById('nom2').innerText;
        document.getElementById('prenom').value=document.getElementById('prenom2').innerText;
        document.getElementById('modificationMotDePasse').style.display="none";
        document.getElementById('modificationInformation').style.display="block";
    }
    function annuler(val){
        document.getElementById(val).style.display="none";
//        $('#annuler').hide();
    }
    function modifierMotDePasse(){
        document.getElementById('modificationInformation').style.display="none";
        document.getElementById('motdepasse').value='';
        document.getElementById('remotdepasse').value='';
        document.getElementById('modificationMotDePasse').style.display="block";
    }
    $('#validerInfo').click(function(){
        if($('#nom').val()==''||$('#prenom').val()==''){
            alert('FORMULAIRE INCOMPLET!')
        }else{
            $('#form-info').submit();
        }
    })
    $('#validerMotDePasse').click(function(){
        if($('#motdepasse').val()==''||$('#remotdepasse').val()==''){
            alert('FORMULAIRE INCOMPLET!')
        }else if($('#motdepasse').val()!=$('#remotdepasse').val()){
            alert('MOT DE PASSSE SASSIE INCORESPONDANT!')
        }else{
            $('#form-mot-de-passe').submit();
        }
    })
</script>

<?php require 'fragmentFooter.html';?>
