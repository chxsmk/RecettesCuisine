<?php

require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/RecetteStorage.php");


class Router
{

    public function __construct(RecetteStorage $recettes)
    {
        $this->recettes = $recettes;
    }

    public function main()
    {
        $view = new View($this);
        $controller = new Controller($view, $this->recettes);
        $recetteBuilder = new RecetteBuilder($this->recettes);
        $id = key_exists('id', $_GET) ? $_GET['id'] : null;

        if (key_exists('id', $_GET)) {
            $controller->showInformation($_GET['id']);
        }

        if (key_exists('action', $_GET)) {
            if ($_GET['action'] == 'accueil') {
                $controller->homeRecettesPage();
            }
            if ($_GET['action'] == 'inscription') {
                $view->makeInscriptionPage();
            }
            if ($_GET['action'] == 'inscrit') {
                $controller->inscription($_POST);
            }
            if ($_GET['action'] == 'seConnecter') {
                $view->makeConnexionPage();
            }
            if ($_GET['action'] == 'connexion') {
                $controller->connexion($_POST);
            }
            if ($_GET['action'] == 'espaceAdmin') {
                $controller->showInformationAdmin();
            }
            if ($_GET['action'] == 'supprimerUtilisateur') {
                $view->makeUserDeletionPage();
            }
            if ($_GET['action'] == 'confirmerSuppressionUtilisateur') {
                $controller->deleteUser($_POST['utilisateur']);
            }
            if ($_GET['action'] == 'deconnexion') {
                session_destroy();
                $controller->homeRecettesPage();
            }
            if ($_GET['action'] == 'nouveau') {
                $controller->addNewRecette($recetteBuilder);
            }
            if ($_GET['action'] == 'sauverNouveau') {
                $controller->saveNewRecette($_POST);
            }
            if ($_GET['action'] == 'supprimer') {
                $controller->askRecetteDeletion($id);
            }
            if ($_GET['action'] == 'confirmerSuppression') {
                $controller->deleteRecette($id);
            }
            if ($_GET['action'] == 'modifier') {
                $controller->recetteModifications($recetteBuilder, $id);
            }
            if ($_GET['action'] == 'sauverModification') {
                if ($id === null) {
                    $view->makeUnknownRecettePage();
                } else {
                    $controller->saveRecetteModifications($_POST, $id);
                }
            }
            if ($_GET['action'] == 'apropos') {
                $view->makeAProposPage();
            }
        }

        if (key_exists('recherche', $_GET)) {
            $recherche = htmlspecialchars($_GET['recherche']);
            $controller->searchRecettesPage($recherche);
        }

        if (empty($_GET)) {
            $controller->homeRecettesPage();
        }
        $view->render();
    }

    public function homePage()
    {
        return "recettes.php?action=accueil";
    }

    public function getRecetteURL($id)
    {
        return $url = "recettes.php?id=" . $id;
    }

    public function getIncriptionFormURL()
    {
        return "recettes.php?action=inscription";
    }

    public function getInscritionURL()
    {
        return "recettes.php?action=inscrit";
    }

    public function getConnexionFormURL()
    {
        return "recettes.php?action=seConnecter";
    }

    public function getConnexionURL()
    {
        return "recettes.php?action=connexion";
    }

    public function getAdminURL()
    {
        return "recettes.php?action=espaceAdmin";
    }

    public function getUserAskDeletionURL()
    {
        return "recettes.php?action=supprimerUtilisateur";
    }

    public function getUserDeletionURL()
    {
        return "recettes.php?action=confirmerSuppressionUtilisateur";
    }
    //Revoir la partie déconnexion
    public function getDeconnexionURL()
    {
        return "recettes.php?action=deconnexion";
    }

    public function getRecetteCreationURL()
    {
        return "recettes.php?action=nouveau";
    }

    public function getRecetteSaveURL()
    {
        return "recettes.php?action=sauverNouveau";
    }

    public function getRecetteAskDeletionURL($id)
    {
        return "recettes.php?id=" . $id . "&amp;action=supprimer";
    }

    public function getRecetteDeletionURL($id)
    {
        return "recettes.php?id=" . $id . "&amp;action=confirmerSuppression";
    }

    public function getRecetteModificationURL($id)
    {
        return "recettes.php?id=" . $id . "&amp;action=modifier";
    }

    public function updateModificationRecette($id)
    {
        return "recettes.php?id=" . $id . "&amp;action=sauverModification";
    }

    public function getAProposURL()
    {
        return "recettes.php?action=apropos";
    }
}
