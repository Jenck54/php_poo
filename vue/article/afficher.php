<article>

    <h1><?= $article['titre'] ?> </h1>
    <legend>Ecrit par : <?= $article['pseudo'] ?></legend>

    <?php
    foreach ($listeCategorie as $categorie) {
    ?>

        <span class="badge rounded-pill bg-success"><?= $categorie['nom'] ?></span>

    <?php
    }
    ?>

    <p>
        <?= $article['contenu'] ?>
    </p>
    <?php
    if ($article['nom_image'] != "" && $article['nom_image'] != NULL) {
    ?>

        <img src="<?= Conf::URL ?>assets/images/<?= $article['nom_image'] ?>">

    <?php
    }
    ?>

</article>

<a class="btn btn-info m-4" href="<?= Conf::URL ?>article/liste">Retour</a>