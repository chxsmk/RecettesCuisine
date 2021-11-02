<?php
    require_once("model/Recette.php");
    require_once("model/RecetteStorageMySQL.php");

    class Controller{
        protected $view;
        protected $recettesdb;

        public function __construct(View $view, RecetteStorageMySql $recettesdb) {
            $this->view = $view;
            $this->recettesdb = $recettesdb;
        }

        public function showInformation($id){
            $recette = $this->recettesdb->read($id);
            if($recette != null){
               //Si le user est connecté on appelle la funcion makeRecetteUserPage sinon on appelle la fonction makeRecettePage
                $this->view->makeRecettePage($recette, $id);
            }
            else{
                $this->view->makeUnknownRecettePage();
            }          
        }

        public function saveNewRecette(array $data){
            $recetteBuilder = new RecetteBuilder($data);
            if($recetteBuilder->isValid()){
                $recette = $recetteBuilder->createRecette();
                $recetteId = $this->recettesdb->create($recette);
                
               //Si le user est connecté on appelle la funcion makeRecetteUserPage sinon on appelle la fonction makeRecettePage
                $this->view->makeRecettePage($recette, $recetteId);
            }   
            else{
                $this->view->makeRecetteCreationPage($recetteBuilder);
            }        
        }

        public function homeRecettesPage(){
            $recettes = $this->recettesdb->readAll();
            $this->view->makeHomePage($recettes);
        }

        public function searchRecettesPage($recherche){
            $recettesRecherche = $this->recettesdb->search($recherche);
            if($recettesRecherche != null){
                $this->view->makeSearchPage($recettesRecherche);
            }
            else{
                $this->view->makeUnknownSearchPage();
            }
        }

        public function askRecetteDeletion($id){
            $recette = $this->recettesdb->read($id);
            if($recette != null){
                $this->view->makeRecetteDeletionPage($id);
            }
            else{
                $this->view->makeUnknownRecettePage();
            }
        }

        public function deleteRecette($id){
            $ok = $this->recettesdb->delete($id);
		    if (!$ok) {
                $this->view->makeUnknownRecettePage();
            } else {
                $this->view->makeRecetteDeletedPage();
            }
        }

        public function recetteModifications($recette, $id){
            $a = $this->recettesdb->read($id);
            $recetteBuilder = $recette->buildFromRecette($a);
            $this->view->makeRecetteModificationPage($recetteBuilder, $id);
        }

        public function saveRecetteModifications(array $data, $id) {
            $recette = $this->recettesdb->read($id);
            if ($recette === null) {
                $this->view->makeUnknownRecettePage();
            } else {
                $recetteBuilder = new recetteBuilder($data);
                if ($recetteBuilder->isValid()) {
                    $recetteBuilder->updateRecette($recette);
                    $ok = $this->recettesdb->update($recette, $id);
                    if (!$ok)
                        throw new Exception("Identifier has disappeared?!");
                    /* Préparation de la page de la couleur */
                    $this->view->makeRecettePage($recette, $id);
                } else {
                    $this->view->makeRecetteModificationPage($recetteBuilder, $id);
                }
            }
        }

        //return true si les données entrées par l'utilisateur sont dans la bd et false sinon.
        public function connexion(array $data){
            $connecte = $this->recettesdb->verifieConnexion($data);
            if($connecte != false){
                $recettes = $this->recettesdb->readAll();
                return $this->view->makeHomePage($recettes);
            }
            else{
                echo 'Erreur';
            }
        }

    }
?>
