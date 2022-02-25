<?php

namespace modele;

use PDOperso;

class ArticleModele extends BaseModele {

    public static function recherche($mot) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'SELECT article.id as id, titre, contenu, nom_image, date_publication, pseudo 
            FROM article
            JOIN utilisateur ON utilisateur.id = article.id_utilisateur
            WHERE titre LIKE :recherche OR contenu LIKE :recherche OR pseudo LIKE :recherche'
        );
        $requete->execute([':recherche' => '%' . $mot . '%']);

        return $requete->fetchAll();
    }

    public static function updateArticle($id, $titre, $contenu, $nouveauNomImage = "") {

        $connexion = new PDOperso();

        if ($nouveauNomImage == NULL) {
            $requete = $connexion->prepare(
                'UPDATE article 
                SET titre = :titre, contenu = :contenu 
                WHERE id = :id'
            );
            $requete->execute([
                ':titre' => $titre,
                ':contenu' => $contenu,
                ':id' => $id
            ]);
        } else {
            $requete = $connexion->prepare(
                'UPDATE article 
                SET titre = :titre, contenu = :contenu, nom_image = :nom_image
                WHERE id = :id'
            );
            $requete->execute([
                ':titre' => $titre,
                ':contenu' => $contenu,
                ':nom_image' => $nouveauNomImage == "" ? NULL : $nouveauNomImage,
                ':id' => $id
            ]);
        }
    }

    public static function findDoublon($titre, $idAexclure) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'SELECT *
            FROM article
            WHERE titre = ?
            AND id != ?'
        );
        $requete->execute([$titre, $idAexclure]);

        return $requete->fetch();
    }

    public static function createArticle($titre, $contenu, $nouveauNomImage, $idAuteur) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "INSERT INTO article (titre,contenu,nom_image,id_utilisateur) 
            VALUES (?,?,?,?)"
        );
        $requete->execute([
            $titre,
            $contenu,
            $nouveauNomImage,
            $idAuteur
        ]);

        return $connexion->lastinsertid();
    }

    public static function findByTitre($titre) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            'SELECT *
            FROM article
            WHERE titre = ?'
        );
        $requete->execute([$titre]);

        return $requete->fetch();
    }

    public static function findAllJoinUtilisateur() {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, nom_image, date_publication, pseudo, id_utilisateur
            FROM article
            LEFT JOIN utilisateur ON utilisateur.id = article.id_utilisateur"
        );
        $requete->execute();

        return $requete->fetchAll();
    }

    public static function findByIdJoinUtilisateur($id) {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT article.id as id_article, titre, contenu, nom_image, date_publication, pseudo
            FROM article
            JOIN utilisateur ON utilisateur.id = article.id_utilisateur
            WHERE article.id = ?"
        );
        $requete->execute([$id]);
        
        return $requete->fetch();
    }
}
?>