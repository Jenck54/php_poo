<div class="container">
    <form method="post">
        <div class="form-group">
            <label class="col-form-label mt-4" for="pseudo">Pseudo</label>
            <input name="pseudo" value="<?= $utilisateur['pseudo'] ?>" type="text" class="form-control" placeholder="ex : Jenck" id="pseudo">
        </div>

        <div class="form-group">
            <label for="droit" class="form-label mt-4">Droit de l'utilisateur</label>
            <select name="droit" id="droit">
                <option value="">Aucun droit</option>
                <?php foreach ($listeDroit as $droit) { ?>
                    <option <?php if ($droit['id'] == $utilisateur['id_droit']) echo 'selected' ?> value="<?= $droit['id'] ?>"><?= $droit['denomination'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mt-5">
            <input name="valider" class="btn btn-info" type="submit" value="Enregistrer">
            <a class="btn btn-warning" href="<?= Conf::URL ?>utilisateur/liste">Annuler</a>
        </div>
    </form>
</div>