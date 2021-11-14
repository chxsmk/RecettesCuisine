<?php
session_start();
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
                session_start();
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
        return "index.php?action=accueil";
    }

    public function getRecetteURL($id)
    {
        return $url = "index.php?id=" . $id;
    }

    public function getIncriptionFormURL()
    {
        return "index.php?action=inscription";
    }

    public function getInscritionURL()
    {
        return "index.php?action=inscrit";
    }

    public function getConnexionFormURL()
    {
        return "index.php?action=seConnecter";
    }

    public function getConnexionURL()
    {
        return "index.php?action=connexion";
    }

    public function getAdminURL()
    {
        return "index.php?action=espaceAdmin";
    }

    public function getUserAskDeletionURL()
    {
        return "index.php?action=supprimerUtilisateur";
    }

    public function getUserDeletionURL()
    {
        return "index.php?action=confirmerSuppressionUtilisateur";
    }
    //Revoir la partie déconnexion
    public function getDeconnexionURL()
    {
        return "index.php?action=deconnexion";
    }

    public function getRecetteCreationURL()
    {
        return "index.php?action=nouveau";
    }

    public function getRecetteSaveURL()
    {
        return "index.php?action=sauverNouveau";
    }

    public function getRecetteAskDeletionURL($id)
    {
        return "index.php?id=" . $id . "&amp;action=supprimer";
    }

    public function getRecetteDeletionURL($id)
    {
        return "index.php?id=" . $id . "&amp;action=confirmerSuppression";
    }

    public function getRecetteModificationURL($id)
    {
        return "index.php?id=" . $id . "&amp;action=modifier";
    }

    public function updateModificationRecette($id)
    {
        return "index.php?id=" . $id . "&amp;action=sauverModification";
    }

    public function getAProposURL()
    {
        return "index.php?action=apropos";
    }
}
