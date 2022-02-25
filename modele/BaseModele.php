<?php

namespace modele;

use PDOperso;

class BaseModele {

    public static function deleteById($id)
    {
        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "DELETE
            FROM " . self::getNomTable() . 
            " WHERE id = ?"
        );
        return $requete->execute([$id]);
    }

    public static function getNomTable() {

        // \modele\ArticleModele
        $nomTable = get_called_class();
        // CategorieArticle
        $nomTable = substr($nomTable, 7, -6);
        // categorieArticle
        $nomTable = lcfirst($nomTable);
        // categorie_Article
        $nomTable = preg_replace( '/([A-Z])/', '_$0', $nomTable);
        // categorie_article
        $nomTable = strtolower($nomTable);

        return $nomTable;

        
    }
    
    public static function findAll()
    {

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            'SELECT * 
            FROM ' . self::getNomTable()
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function findById($id) {

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "SELECT * 
            FROM " . self::getNomTable() . 
            " WHERE id = ?" 
        );
        $requete->execute([$id]);
        return $requete->fetch();
    }
}
?>