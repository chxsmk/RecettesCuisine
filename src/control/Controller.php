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
            if ($recette != null) {
                $this->view->makeRecettePage($recette, $id);
            } else {
                $this->view->makeUnknownRecettePage();
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
        $ok = $this->recettesdb->delete($id);
        if (!$ok) {
            $this->view->makeUnknownRecettePage();
        } else {
            $this->view->makeRecetteDeletedPage();
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
        if ($connecte != null) {
            //compte existe
            $this->view->makeConnexionPage();
        } else {
            //Ajout à la bd
            $this->recettesdb->addNewIncription($data);
            $_SESSION['username'] = $data['username'];
            $recettes = $this->recettesdb->readAll();
            $this->view->makeHomePage($recettes);
        }
    }

    public function connexion(array $data)
    {
        $connecte = $this->recettesdb->verification($data);
        if ($connecte != null) {
            $_SESSION['username'] = $data['username'];
            $recettes = $this->recettesdb->readAll();
            $this->view->makeHomePage($recettes);
        } else {
            $this->view->makeConnexionPage();
        }
    }
}
