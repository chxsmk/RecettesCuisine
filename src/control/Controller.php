<?php
require_once("model/Recette.php");
require_once("model/RecetteStorageMySQL.php");

class Controller
{
    protected $view;
    protected $recettesdb;

    public function __construct(View $view, RecetteStorageMySql $recettesdb)
    {
        $this->view = $view;
        $this->recettesdb = $recettesdb;
    }

    public function showInformation($id)
    {
        if (key_exists('username', $_SESSION)) {
            $recette = $this->recettesdb->read($id);
            $user = $_SESSION['username'];
            if ($recette != null) {
                $this->view->makeRecettePage($recette, $id);
            } else {
                $this->view->makeUnknownRecettePage();
            }
        } else {
            $this->view->makeNoUserPage();
        }
    }

    public function showInformationAdmin()
    {
        if (key_exists('username', $_SESSION)) {
            $user = $_SESSION['username'];
            if (($this->recettesdb->isAdmin($user))) {
                $users = $this->recettesdb->readAllUsers();
                $this->view->makeAdminPage($users);
            } else {
                $this->view->makeNoAdminPage();
            }
        } else {
            $this->view->makeNoUserPage();
        }
    }

    public function addNewRecette($recetteBuilder)
    {
        if (key_exists('username', $_SESSION)) {
            $this->view->makeRecetteCreationPage($recetteBuilder);
        } else {
            $this->view->makeNoUserPage();
        }
    }

    public function saveNewRecette(array $data)
    {
        $recetteBuilder = new RecetteBuilder($data);
        if ($recetteBuilder->isValid()) {
            $recette = $recetteBuilder->createRecette();
            $recetteId = $this->recettesdb->create($recette);
            $this->view->makeRecettePage($recette, $recetteId);
        } else {
            $this->view->makeRecetteCreationPage($recetteBuilder);
        }
    }

    public function homeRecettesPage()
    {
        $recettes = $this->recettesdb->readAll();
        $this->view->makeHomePage($recettes);
    }

    public function searchRecettesPage($recherche)
    {
        $recettesRecherche = $this->recettesdb->search($recherche);
        if ($recettesRecherche != null) {
            $this->view->makeSearchPage($recettesRecherche);
        } else {
            $this->view->makeUnknownSearchPage();
        }
    }

    public function askRecetteDeletion($id)
    {
        $recette = $this->recettesdb->read($id);
        if ($recette != null) {
            $this->view->makeRecetteDeletionPage($id);
        } else {
            $this->view->makeUnknownRecettePage();
        }
    }

    public function deleteRecette($id)
    {
        $supp = $this->recettesdb->deleteRecette($id);
        if (!$supp) {
            $this->view->makeUnknownRecettePage();
        } else {
            header('Location: index.php?action=accueil');
        }
    }

    public function recetteModifications($recette, $id)
    {
        $r = $this->recettesdb->read($id);
        if (key_exists('username', $_SESSION)) {
            $recetteBuilder = $recette->buildFromRecette($r);
            $this->view->makeRecetteModificationPage($recetteBuilder, $id);
        } else {
            $this->view->makeNoUserPage();
        }
    }

    public function saveRecetteModifications(array $data, $id)
    {
        $recette = $this->recettesdb->read($id);
        if ($recette === null) {
            $this->view->makeUnknownRecettePage();
        } else {
            $recetteBuilder = new recetteBuilder($data);
            if ($recetteBuilder->isValid()) {
                $recetteBuilder->updateRecette($recette);
                $nouvelleRecette = $this->recettesdb->update($recette, $id);
                if (!$nouvelleRecette) {
                    throw new Exception("Identifier has disappeared?!");
                } else {
                    $this->view->makeRecettePage($recette, $id);
                }
            } else {
                $this->view->makeRecetteModificationPage($recetteBuilder, $id);
            }
        }
    }

    public function inscription(array $data)
    {
        $connecte = $this->recettesdb->verification($data);
        if ($data['username'] == 'admin') {
            $this->view->makeAutreNomPage();
        } else {
            if ($connecte != null) {
                $this->view->makeExistComptePage();
            } else {
                $this->recettesdb->addNewIncription($data);
                $_SESSION['username'] = $data['username'];
                header('Location: index.php?action=accueil');
            }
        }
    }

    public function connexion(array $data)
    {
        $connecte = $this->recettesdb->verification($data);
        if ($connecte != null) {
            $_SESSION['username'] = $data['username'];
            header('Location: index.php?action=accueil');
        } else {
            $this->view->makeUnknownUserPage();
        }
    }

    public function deleteUser($user)
    {
        if ($this->recettesdb->userExist($user)) {
            $this->recettesdb->deleteUsername($user);
            header('Location: index.php?action=espaceAdmin');
        } else {
            $this->view->makeUnknownUserPage();
        }
    }
}
