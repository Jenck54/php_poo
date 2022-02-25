<?php
if (isset($_SESSION['droit']) && ($_SESSION['droit'] == 'admin' || $_SESSION['droit'] == 'redacteur')) {
?>

    <a href="<?= Conf::URL ?>article/insertion" class="btn btn-danger m-4">Ajouter un article</a>

<?php
}

if (count($listeArticle) == 0 && isset($estUneRecherche) && $estUneRecherche) {
?>

<h3>Aucun article ne correspond a votre recherche</h3>

<?php
} else {
?>

    <?php
    foreach ($listeArticle as $article) {
    ?>

        <div class="card bg-secondary mb-3" style="max-width: 20rem;">
            <div class="card-header">Ecrit par : <?= htmlentities($article['pseudo']) ?></div>
            <div class="card-body">
                <h4 class="card-title"><?= htmlentities($article["titre"]) ?></h4>

                <?php
                if ($article['nom_image']) {
                ?>

                    <img class="img-fluid" src="<?= Conf::URL ?>assets/images/<?= $article['nom_image'] ?>">

                <?php
                }
                ?>

                <p class="card-text"><?= htmlentities($article["contenu"]) ?></p>
                <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i></a>

                <?php
                // Si l'utilisateur est connecté ET si l'utilisateur est admin OU s'il est l'auteur de l'article
                if ((isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') || (isset($_SESSION['id']) && $_SESSION['id'] == $article['id_utilisateur'])) {
                ?>
                    <a href="<?= Conf::URL ?>article/edition/<?= $article["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>

                <?php
                }
                ?>
            </div>
        </div>

<?php
    }
}
