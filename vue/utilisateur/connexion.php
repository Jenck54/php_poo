<form method="post">
    <div class="form-group">
        <label class="col-form-label mt-4" for="pseudo">Pseudo</label>
        <input name="pseudo" value="<?php if (isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" type="text" class="form-control" placeholder="ex : Jenck" id="pseudo">
    </div>

    <div class="form-group">
        <label for="mot_de_passe" class="form-label mt-4">Mot de passe</label>
        <input name="mot_de_passe" type="password" class="form-control" id="mot_de_passe">
    </div>

    <?php if ($erreurPseudo) { ?>
        <p class="text-danger">Le pseudo ou le mot de passe n'existe pas</p>
    <?php } ?>

    <input name="valider" type="submit" class="btn btn-info mt-4" value="Se connecter">
    <a class="btn btn-danger mt-4" href="<?= Conf::URL ?>">Annuler</a>
</form>