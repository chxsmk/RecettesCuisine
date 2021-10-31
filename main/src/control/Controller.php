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
                $this->view->makeRecettePage($recette, $id);
            }
            else{
                $this->view->makeUnknownrecettePage();
            }          
        }

        public function saveNewRecette(array $data){
            $recetteBuilder = new recetteBuilder($data);
            if($recetteBuilder->isValid()){
                $recette = $recetteBuilder->createRecette();
                $recetteId = $this->recettesdb->create($recette);
                //if($recetteId !==false){} // pq "recetteId" 
                $this->view->makeRecettePage($recette, $recetteId);
            }   
            else{
                $this->view->makeRecetteCreationPage($recetteBuilder);
            }        
        }

        public function listeRecettesPage(){
            $recettes = $this->recettesdb->readAll();
            $this->view->makeListPage($recettes);
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

        public function deleterecette($id){
            $ok = $this->recettesdb->delete($id);
		    if (!$ok) {
                $this->view->makeUnknownrecettePage();
            } else {
                $this->view->makerecetteDeletedPage();
            }
        }

        public function recetteModifications($recette, $id){
            $a = $this->recettesdb->read($id);
            $recetteBuilder = $recette->buildFromrecette($a);
            $this->view->makerecetteModificationPage($recetteBuilder, $id);
        }

        public function saverecetteModifications(array $data, $id) {
            $recette = $this->recettesdb->read($id);
            if ($recette === null) {
                $this->view->makeUnknownrecettePage();
            } else {
                $recetteBuilder = new recetteBuilder($data);
                if ($recetteBuilder->isValid()) {
                    $recetteBuilder->updaterecette($recette);
                    $ok = $this->recettesdb->update($recette, $id);
                    if (!$ok)
                        throw new Exception("Identifier has disappeared?!");
                    /* Préparation de la page de la couleur */
                    $this->view->makerecettePage($recette, $id);
                } else {
                    $this->view->makerecetteModificationPage($recetteBuilder, $id);
                }
            }
        }

        //return true si les données entrées par l'utilisateur sont dans la bd et false sinon.
        public function connexion(array $data){
            $connecte = $this->recettesdb->verifieConnexion($data);
            if($connecte != false){
                return $this->view->makeHomePage();
            }
            else{
                echo 'Erreur';
            }
        }

    }
?>