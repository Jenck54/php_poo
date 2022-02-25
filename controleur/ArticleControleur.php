<?php

namespace controleur;

use PDOperso;
use Conf;
use modele\ArticleModele;
use modele\CategorieArticleModele;
use modele\CategorieModele;

class ArticleControleur extends BaseControleur
{

    public function liste()
    {
        $listeArticle = ArticleModele::findAllJoinUtilisateur();

        $parametres = compact('listeArticle');

        $this->afficherVue($parametres);
    }

    public function afficher($id)
    {
        $article = ArticleModele::findByIdJoinUtilisateur($id);

        if ($article) {

            // On récupère toutes les catégories de cet article
            $listeCategorie = CategorieArticleModele::findByIdArticleJoinCategorie($id);

            $parametres = compact('article', 'listeCategorie');

            $this->afficherVue($parametres, 'afficher');
        } else {
            header('Location: ' . Conf::URL . 'page/PageNonTrouve');
        }
    }

    public function insertion()
    {
        $erreurDoublon = false;

        if (isset($_SESSION['droit']) && ($_SESSION['droit'] == 'admin' || $_SESSION['droit'] == 'redacteur')) {

            $connexion = new PDOperso();;

            $listeCategorie = CategorieModele::findAll();

            //si l'utilisateur a validé le formulaire
            if (isset($_POST['valider'])) {

                $doublon = ArticleModele::findByTitre($_POST['titre']);

                if (!$doublon) {

                    $nouveauNom = NULL;

                    // Si l'utilisateur a selectionné une image
                    if ($_FILES['image']['tmp_name'] != "") {
                        $nomTemporaire = $_FILES['image']['tmp_name'];
                        // On crée un nom unique à partir du titre de l'article
                        $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";
                        move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
                    }

                    

                    $idArticle = ArticleModele::createArticle(
                        $_POST['titre'],
                        $_POST['contenu'],
                        $nouveauNom,
                        $_SESSION['id']
                    );

                    foreach ($_POST['categorie'] as $idCategorie) {
                        CategorieArticleModele::create($idArticle, $idCategorie);
                    }


                    header('Location: ' . Conf::URL . 'article/liste');
                } else {
                    $erreurDoublon = true;
                }
            }

            $parametres = compact('erreurDoublon', 'listeCategorie');

            $this->afficherVue($parametres, 'insertion');
        }
    }

    public function supprimer($id)
    {
        $article = ArticleModele::findById($id);

        if ((isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') || (isset($_SESSION['id']) && $_SESSION['id'] == $article['id_utilisateur'])) {

            ArticleModele::deleteById($id);

            header('Location: ' . Conf::URL . "article/liste");
        } else {
            header('Location: ' . Conf::URL);
        }
    }
    public function edition($id)
    {
        // On récupère l'article a modifier
        $article = ArticleModele::findById($id);

        // On récupère la liste des catégories
        $listeCategorie = CategorieModele::findAll();

        // On récupère les catégories de l'article
        $listeCategorieArticle = CategorieArticleModele::findByIdArticle($id);

        // Si l'utilisateur est administrateur ou auteur de l'article
        if ((isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') || (isset($_SESSION['id']) && $_SESSION['id'] == $article['id_utilisateur'])) {

            $erreurDoublon = false;

            // Si il a validé le formulaire ou si il supprime l'image
            if (isset($_POST['valider']) || isset($_POST['suppression_image'])) {

                $doublon = ArticleModele::findDoublon($_POST['titre'], $id);

                // Si le titre n'existe pas déjà
                if (!$doublon) {

                    // Si il a validé le formulaire
                    if (isset($_POST['valider'])) {

                        $nouveauNom = NULL;

                        // Si l'utilisateur a selectionné une image
                        if ($_FILES['image']['tmp_name'] != "") {
                            $nomTemporaire = $_FILES['image']['tmp_name'];
                            // On crée un nom unique à partir du titre de l'article
                            $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . "_" . time() . ".jpg";
                            move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
                        }

                        ArticleModele::updateArticle(
                            $id, 
                            $_POST['titre'], 
                            $_POST['contenu'], 
                            $nouveauNom
                        );

                        header('Location: ' . Conf::URL . 'article/liste');
                    } else if (isset($_POST['suppression_image'])) {

                        ArticleModele::updateArticle(
                            $id,
                            $_POST['titre'],
                            $_POST['contenu']
                        );

                        header('Location: ' . Conf::URL . 'article/edition/' . $id);
                    }
                } else {
                    $erreurDoublon = true;
                }

                // On efface toutes les catégories de cet article
                CategorieArticleModele::deleteByIdArticle($id);

                // Enregistrer les catégories
                foreach ($_POST['categorie'] as $idCategorie) {
                    
                    CategorieArticleModele::create($id, $idCategorie);
                }
            }

            $parametres = compact(
                'article',
                'erreurDoublon',
                'listeCategorie',
                'listeCategorieArticle'
            );

            $this->afficherVue($parametres, 'edition');
        } else {
            header('Location: ' . Conf::URL);
        }
    }

    public function recherche($mot)
    {

        $listeArticle = ArticleModele::recherche($mot);

        $estUneRecherche = true;

        $parametres = compact('listeArticle', 'estUneRecherche');

        $this->afficherVue($parametres);
    }
}