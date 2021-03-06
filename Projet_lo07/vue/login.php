<?php
require 'fragmentHeader.html';
?>
<div class="login-form">
    <form action="router.php?action=validerLogin" method="post">
        <h2 class="text-center">Se connecter</h2>
        <div class="form-group">
            <input type="text" name="login" class="form-control" placeholder="Login">
        </div>
        <div class="form-group">
            <input type="password" name="motDePasse" class="form-control" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox">Se souvenir de moi</label>
            <a href="#" class="pull-right">Mot de passe oublié ?</a>
        </div>
    </form>
    <p class="text-center" style='margin-left: 20%'><a href="router.php?action=inscription">Créer un nouveau compte</a></p>
</div>
<?php
require 'fragmentFooter.html';
