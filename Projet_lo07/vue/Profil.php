<?php 
require 'fragmentHeader.html';
require 'menuUtilisateur.html';
//require_once './modele/utilisateur.php';
require'./modele/gare.php'
?>
<h1><img src='./vue/espaceClient.png' style="width: 100px;height: 100px"> Espace personnelle</h1>
<div class="tab">
    <button class="tablink" id='info' onclick="ouvrirFenetre(event,'mesinfos')">Mes informations</button>
    <button class="tablink" id='vehicule' onclick="ouvrirFenetre(event,'mesvehicules')">Mes Vehicules</button>
    <button class="tablink" id='reservation' onclick="ouvrirFenetre(event,'mesreservation')">Mes reservations</button>
</div>

<script>$('#info').click()</script>
<div id="mesinfos"class="tabcontent" >
   
    <table class='table table-bordered' style='border-color: #4d4d4d;width: 200px'>
                <tr><th class='text-center' colspan="2">Mes informations</th></tr>
                <tr>
                    <th>Nom</th>
                     <?php
                        printf("<td>%s</td>",$utilisateur->getNom());
                     ?>
                </tr>
                <tr>
                    <th>Prenom</th>
                     <?php
                        printf("<td>%s</td>",$utilisateur->getPrenom());
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
    <form action='router.php' method="get">
        <input type='hidden' id='action' value="modifierInfos">
        <button type='submit' class="btn btn-primary">Modifier mes informations</button>
    </form>
</div>
<div class="tabcontent" id="mesvehicules">
    <table class="table table-bordered">
        <tr><th class='text-center' colspan="5">Vos vehicules</th></tr>

        <tr>
            <th>Nummero de plaque</th>
            <th>Marque</th>
            <th>Modele</th>
            <th>Transmission</th>
            <th>Prix par heure</th>
        </tr>
            <?php 
                foreach ($listeVehicules as $ele){
                    echo'<tr>';
                    $ele->toString();
                    echo'</tr>';
                }
            ?>
    </table>
    <form action='router.php' method="get">
            <input type='hidden' id='action' value="modifierVehicules">
            <button type='submit' class="btn btn-primary">Modifier mes vehicules</button>
    </form>  
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
