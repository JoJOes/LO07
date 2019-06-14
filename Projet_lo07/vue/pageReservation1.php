<?php
require './vue/fragmentHeader.html';
require './vue/menuUtilisateur.html';
$message='thu suong';
//require './Fonction.php';
//leverErreur($message);
?>

<div class='container'>
    <div class="row">
        <div class='page-reservation'>
            <div class='tete-reservation'><h1>Voulez-vous réserver une place pour votre véhicule?</h1></div>
            <div class='parking-reservation'><img src='./vue/images.jpg' width="40px" height="40px"><h3>Parking</h3></div>
            <!--<form method="GET" action="router.php?action=reservation2">--> 
            <form id='form1' action="router.php" method="GET" > 

                <input type='hidden' name='action' value='reservation2'>
                <div class='form-group'>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <!--<div class='form-aeroport'>-->
                        <label for='list-aeroport'>Aéroport</label>
                        <select id='list-aeroport' name="list-aeroport" class='form-control'>.
                             <option></option>
                            <?php
                            foreach ($listeAeroports as $ele){
                                printf("<option value='%s'>".$ele."</option>",$ele);
                            }
                            ?>
                        </select>
                        <!--</div>-->
                    </div>
                    <div class="col-md-3">
                        <!--<div class='form-date'>-->
                            <label for='date1' >Date de début</label>
                            <input class='form-control' type='datetime-local' id='date1' name="date1">
                        <!--</div>-->
                    </div>
                    <div class="col-md-3">
                        <!--<div class='form-date'>-->
                            <label for='date2'>Date de fin</label>
                            <input class='form-control' type='datetime-local' id='date2' name="date2">
                        <!--</div>-->
                     </div>

                </div>
                <!--<input class='btn btn-default' type='submit' value='rechercher'>-->
                <button type='button' class="btn btn-default" onclick='verifier()'>Rechercher</button>
                <div class="clearfix"></div>

            
        </div>
    </div>
</div>

<script>
//    $("button").attr("disabled", true);
    function verifier(){
        if($('select').val()==''||$('#date1').val()==''||$('#date2').val()==''){
            alert('FORMULAIRE INCOMPLET!')
        }else{
            $('#form1').submit();
        }
    }
//    $('select').change(function(){
//        if($('select').val()!=''){
//            $("button").attr("disabled", false);
//        }else{
//            $("button").attr("disabled", true);
//        }
//    })
    
</script>

<?php require 'fragmentFooter.html';?>