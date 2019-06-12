<?php 
require 'fragmentHeader.html';
require 'menuUtilisateur.html';
?>
<h1><img src='espaceClient.png' style="width: 100px;height: 100px"> Espace personnelle</h1>
<div class="tab">
    <button class="tablink" onclick="ouvrirFenetre(event,'mesinfos')">Mes informations</button>
    <button class="tablink" onclick="ouvrirFenetre(event,'mesvehicules')">Mes Vehicules</button>
    <button class="tablink" onclick="ouvrirFenetre(event,'mesreservation')">Mes reservations</button>
</div>

<div id="mesinfos"class="tabcontent" >
   
    <table class='table table-bordered' style='border-color: #4d4d4d;width: 200px'>
                <tr><th colspan="2">Mes informations</th></tr>
                <tr>
                    <td>Nom</td>
                     <?php
                        printf("<td>".$utilisateur->getNom()."</td>");
                     ?>
                </tr>
                <tr>
                    <td>Prenom</td>
                     <?php
                        printf("<td>".$utilisateur->getPrenom()."</td>");
                     ?>
                </tr>
                <tr>
                    <td>admin</td>
                     <?php
                        if($utilisateur->getAmin()==0){
                            printf("<td>non</td>");
                        }
                        else{
                            printf("<td>oui</td>");
                        }
                        
                     ?>
                </tr>
    </table>
    <form action='router.php' method="get">
        <input type='hidden' id='action' value="modifierInfos">
        <button type='submit' class="btn btn-primary">Modifier mes informations</button>
    </form>
</div>
<div class="tabcontent" id="mesvehicules">
    <table class="table table-bordered">
        <tr><th colspan="5">Vos vehicules</th></tr>

        <tr>
            <td>Nummero de plaque</td>
            <td>Marque</td>
            <td>Modele</td>
            <td>Transmission</td>
            <td>prix</td>
        </tr>
        <tr>
            <?php $vehicules->toString()?>
        </tr>
    </table>
    <form action='router.php' method="get">
            <input type='hidden' id='action' value="modifierVehicules">
            <button type='submit' class="btn btn-primary">Modifier mes vehicules</button>
    </form>  
</div>
<div class="tabcontent" id="mesreservation">
    <div class="row">
        <div class="col-md-5">
            <table title="Les places reservees">
                <tr>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
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
</script>

<?php require 'fragmentFooter.html';?>
