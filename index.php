<?php
session_start();
include('Autoloader.php');
Autoloader::start();

//ex : http://localhost/cci_2022_php_poo/index.php?chemin=article/afficher/42
$chemin = str_replace("/parametre=", "/", $_GET['chemin']);
$partiesChemin = explode("/", $chemin);

// Si l'utilisateur a fourni la première prtie de l'URL (le controleur)
if (isset($partiesChemin[0]) && $partiesChemin[0] != "") {
    $nomControleur = "controleur\\" . ucfirst($partiesChemin[0]) . "Controleur"; //ex : controleur\ArticleControleur
    // Sinon le controleur sera ArticleControleur par défaut
} else {
    $nomControleur = "controleur\\ArticleControleur";
}
// Si l'utilisateur a fourni la seconde partie de l'URL (l'action)
if (isset($partiesChemin[1]) && $partiesChemin[1] != "") {
    $nomAction = $partiesChemin[1]; //Ex : liste
    // Sinon l'action sera liste par défaut
} else {
    $nomAction = "liste";
}
//si l'url comporte un parametre, et que celle-ci ne fini pas par un slash
//ex localhost/.../article/afficher/42
//note : localhost/.../article/afficher/ ne marche pas.
if (isset($partiesChemin[2]) && $partiesChemin[2] != "") {
    $parametre = $partiesChemin[2]; //ex : 42
} else {
    $parametre = null;
}


//si la classe et sa méthode existe
if (!method_exists($nomControleur, $nomAction)) {

    $nomControleur = "controleur\\PageControleur";
    $nomAction = "PageNonTrouve";
}

$controleur = new $nomControleur();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= Conf::URL ?>assets/css/bootstrap.min.css">
    <script defer src="<?= Conf::URL ?>assets/js/bootstrap.min.js"></script>
    <script defer src="https://kit.fontawesome.com/5953448831.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= Conf::URL ?>">Super Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= Conf::URL ?>">Accueil</a>
                    </li>

                    <?php
                    if (isset($_SESSION['pseudo'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/deconnexion">Déconnexion</a>
                        </li>
                    <?php
                    } else {

                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/connexion">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/inscription">Inscription</a>
                        </li>


                    <?php
                    }

                    if (isset($_SESSION['droit']) && ($_SESSION['droit'] == 'admin' || $_SESSION['droit'] == 'redacteur')) {
                    ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= Conf::URL ?>utilisateur">Utilisateurs</a>
                        </li>

                    <?php
                    }
                    ?>
                </ul>

                <?php
                if (isset($_SESSION['pseudo'])) {
                ?>

                    <div class="text-info m-4">
                        Bienvenu <?= $_SESSION['pseudo'] ?>
                    </div>

                <?php
                }
                ?>

                <form method="GET" class="d-flex" action="<?= Conf::URL ?>article/recherche">
                    <input name="parametre" class="form-control me-sm-2" type="text" placeholder="Titre, contenu...">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    $controleur->$nomAction($parametre);
    ?>
</body>

</html>