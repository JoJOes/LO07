<?php
require 'fragmentHeader.html';
?>
<div class="login-form">
    <form action="router.php?action=validerInscription" method="post">
        <h2 class="text-center">S'inscrire</h2>
        <div class="form-group">
            <input type="text" name="login" class="form-control" placeholder="Login">
        </div>
        <div class="form-group">
            <input type="password" name"motDePasse" class="form-control" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <input type="text" name="nom" class="form-control" placeholder="Nom">
        </div>
        <div class="form-group">
            <input type="text" name"prenom" class="form-control" placeholder="Prénom">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </div>
    </form>
    <p class="text-center"><a href="router.php?action=login">Se connecter</a></p>
</div>
<?php
require 'fragmentFooter.html';
