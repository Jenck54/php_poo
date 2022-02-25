<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label class="col-form-label mt-4" for="titre">Titre</label>
        <input name="titre" type="text" class="form-control" placeholder="Titre de l'article" id="titre">
    </div>

    <?php
    if ($erreurDoublon) {
    ?>

        <p class="text-danger">Ce titre existe déjà</p>

    <?php
    }
    ?>

    <div class="form-group">
        <label for="contenu" class="form-label mt-4">Contenu</label>
        <textarea name="contenu" class="form-control" id="contenu" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="image" class="form-label mt-4">Image</label>
        <input name="image" class="form-control" type="file" id="image">
    </div>

    <div class="mt-4>
        <?php
        foreach ($listeCategorie as $categorie) {
        ?>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="<?= $categorie['id'] ?>" id="nomCategorie" name="categorie[]">
                <label class="form-check-label" for="nomCategorie"><?= $categorie['nom'] ?></label>
            </div>

        <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <input name="valider" class="btn btn-primary" type="submit" value="Enregistrer">
        <a class="btn btn-primary" href="<?= Conf::URL ?>article/liste">Annuler</a>
    </div>

</form>