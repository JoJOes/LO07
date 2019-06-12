<?php
require 'fragmentHeader.html';
?>
<div class="login-form">
    <form action="router.php" method="post">
        <input type="hidden" id="action" value="validerLogin">
        <h2 class="text-center">Se connecter</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Id">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="#" class="pull-right">Oublier le mot de passe?</a>
        </div>        
    </form>
    <p class="text-center"><a href="#">Creer un nouveau compte</a></p>
</div>
<?php
require 'fragmentFooter.html';




