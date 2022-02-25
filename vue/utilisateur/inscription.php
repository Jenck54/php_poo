<form method="post">
    <div class="form-group">
        <label class="col-form-label mt-4" for="pseudo">Pseudo</label>
        <input name="pseudo" value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" type="text" class="form-control" placeholder="ex : Jenck" id="pseudo">
    </div>

    <?php if ($erreurLongueurPseudo) { ?>
        <p class="text-danger">Le pseudo doit contenir au moins 5 caractères</p>
    <?php } ?>

    <div class="form-group">
        <label for="mot_de_passe" class="form-label mt-4">Mot de passe</label>
        <input name="mot_de_passe" type="password" class="form-control" id="mot_de_passe">
    </div>

    <div class="form-group">
        <label for="confirmer_mot_de_passe" class="form-label mt-4">Confirmer le mot de passe</label>
        <input name="confirmer_mot_de_passe" type="password" class="form-control" id="confirmer_mot_de_passe">
    </div>

    <?php if ($erreurMotDePasseIdentique) { ?>
        <p class="text-danger">Les mots de passe sont différents</p>
    <?php } ?>

    <input name="valider" type="submit" class="btn btn-info mt-4" value="S'inscrire">
    <a class="btn btn-danger mt-4" href="<?= Conf::URL ?>">Annuler</a>
</form>