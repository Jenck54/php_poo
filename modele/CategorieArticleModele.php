<?php

namespace modele;

use PDOperso;

class CategorieArticleModele extends BaseModele {

    public static function create($idArticle, $idCategorie) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'INSERT INTO categorie_article (id_article, id_categorie)
            VALUES (?, ?)'
        );
        $requete->execute([$idArticle, $idCategorie]);
    }

    public static function findByIdArticleJoinCategorie($id) {

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "SELECT * 
            FROM categorie_article
            JOIN categorie ON categorie.id = categorie_article.id_categorie
            WHERE id_article = ?"
        );
        $requete->execute([$id]);

        return $requete->fetchAll();
    }

    public static function findByIdArticle($id) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'SELECT *
            FROM categorie_article
            WHERE id_article = ?'
        );
        $requete->execute([$id]);

        return $requete->fetchAll();
    }

    public static function deleteByIdArticle($idArticle) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'DELETE
            FROM categorie_article
            WHERE id_article = ?'
        );
        $requete->execute([$idArticle]);
    }
}
?>