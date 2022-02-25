<?php

namespace controleur;

use PDOperso;
use Conf;
use modele\DroitModele;
use modele\UtilisateurModele;

class UtilisateurControleur extends BaseControleur
{
    public function liste()
    {
        if (isset($_SESSION['droit']) && ($_SESSION['droit'] == 'admin' || $_SESSION['droit'] == 'redacteur')) {

            $listeUtilisateur = UtilisateurModele::findAllJoinDroit();

            $parametres = compact('listeUtilisateur');

            $this->afficherVue($parametres);
        } else {
            header("Location: " . Conf::URL);
        }
    }

    public function connexion()
    {
        $erreurPseudo = false;
        // Si l'utilisateur valide la connexion
        if (isset($_POST['valider'])) {
            
            $utilisateur = UtilisateurModele::findByPseudoJoinDroit($_POST['pseudo']);

            // Si l'utilisateur existe bien
            if ($utilisateur) {
                // Si l'utilisateur a saisi un mot de passe compatible avec le mot de passe crypté
                if (password_verify($_POST['mot_de_passe'], $utilisateur['mot_de_passe'])) {
                    $_SESSION['id'] = $utilisateur['id'];
                    $_SESSION['pseudo'] = $utilisateur['pseudo'];
                    $_SESSION['droit'] = $utilisateur['denomination'];

                    header("Location: " . Conf::URL);
                } else {
                    // Si l'utilisateur a saisi un mauvais MOT DE PASSE = erreur
                    $erreurPseudo = true;
                }
            } else {
                // Si l'utilisateur a saisi un mauvais PSEUDO = erreur
                $erreurPseudo = true;
            }
        }

        $parametres = compact('erreurPseudo');

        $this->afficherVue($parametres, 'connexion');
    }

    public function inscription()
    {

        $erreurLongueurPseudo = false;
        $erreurMotDePasseIdentique = false;

        if (isset($_POST['valider'])) {

            if (strlen($_POST['pseudo']) < 5) {
                $erreurLongueurPseudo = true;
            } else if ($_POST['mot_de_passe'] != $_POST['confirmer_mot_de_passe']) {
                $erreurMotDePasseIdentique = true;
            } else {
                UtilisateurModele::create(
                    $_POST['pseudo'],
                    password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT));

                header("Location: " . Conf::URL . "utilisateur/connexion");
            }
        }

        $parametres = compact('erreurLongueurPseudo', 'erreurMotDePasseIdentique');

        $this->afficherVue($parametres, 'inscription');
    }

    public function deconnexion()
    {
        session_destroy();
        header("Location: " . Conf::URL);
    }

    public function supprimer($id)
    {
        if (isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') {

        UtilisateurModele::deleteById($id);

        } else {
            header("Location: " . Conf::URL . "utilisateur");
        }
    }

    public function edition($id)
    {
        if (isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin') {
            // Récupération des droits
            

            // Si l'utilisateur a validé le formulaire
            if(isset($_POST['valider'])) {

                if($_POST['droit'] == "") {
                    $droit = NULL;
                } else {
                    $droit = $_POST['droit'];
                }

                UtilisateurModele::update(
                    $_POST['pseudo'],
                    $droit,
                    $id
                );
            }

            $listeDroit = DroitModele::findAll();

            // Récupération de l'utilisateur
            $utilisateur = UtilisateurModele::findById($id);

            // $parametres['listeDroit'] = $listeDroit;
            $parametres = compact('listeDroit', 'utilisateur');

            $this->afficherVue($parametres, 'edition');
        
        } else {
            header("Location: " . Conf::URL . "utilisateur");
        }
    }
}