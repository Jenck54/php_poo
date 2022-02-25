AFFICHAGE DES UTILISATEURS
<?php
foreach ($listeUtilisateur as $utilisateur) {
?>

    <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
        <div class="card-header"><?= $utilisateur['pseudo'] ?></div>
        <div class="card-body">
            <h4 class="card-title"><?= $utilisateur['denomination'] ?></h4>
        </div>


        <?php
        if (isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') {
        ?>
            <div>
                <a href="<?= Conf::URL ?>utilisateur/edition/<?= $utilisateur["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="<?= Conf::URL ?>utilisateur/supprimer/<?= $utilisateur["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
            </div>

        <?php
        }
        ?>
    </div>

<?php
}
?>