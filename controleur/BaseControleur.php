<?php

namespace controleur;

class BaseControleur {
    public function afficherVue($parametres = [], $vue = 'liste') {

        // $listeArticle = $parametres['listeArticle'];
        extract($parametres);
        
        $dossier = strtolower(substr(get_class($this),11,-10));

        include('vue/'.$dossier."/".$vue.'.php');
    }
}
?>