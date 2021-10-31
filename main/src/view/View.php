<?php
    require_once("model/Recette.php");
    require_once("model/RecetteBuilder.php");

    class View{
        protected $title;
        protected $content;
        protected $nom;
        protected $recette;
        protected $router;

        public function __construct(Router $router) {
            $this->title = null;
            $this->nom = null;
            $this->recette = null;
            $this->content = null;
            $this->router = $router;
        }

        public function render(){
            include "squelette.php";
        }  

        public function makeHomePage(){
            $this->title = "Bienvenue !";
            $this->content = "<p>Voici la page d'accueil sur les recettes !</p>";
        }

        public function makeRecettePage(Recette $recette, $id){
            $this->title = "Recette pour : " . $recette->getNom();
            $this->content = "Voici la recette : <br /> " . $recette->getRecette() . "<br />";
            $this->content .= "<a href='" . $this->router->getRecetteAskDeletionURL($id) . "'> Supprimer la recette </a><br />";
            $this->content .= "<a href='" . $this->router->getRecetteModificationURL($id) . "'> Modifier la recette </a><br />";
        }

        public function makeUnknownrecettePage(){
            $this->title = "Erreur";
		    $this->content = "<p> La page demandée n'existe pas. </p>";
        }

        public function makeListPage($tableau){
            $this->title = "Toutes les recettes";
            $this->content = "<p>Cliquer sur un nom pour voir les détails.</p>";
            $this->content .= "<ul>";
            foreach($tableau as $key=>$value){
                $id = $this->router->getRecetteURL($value['id']);
                $this->content .= "<a href='" . $id . "'>" . $value['nom'] . "</a><br />";
            }
            $this->content .= "</ul>";
        }

        public function makeDebugPage($variable) {
            $this->title = 'Debug';
            $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
        }

        public function makerecetteCreationPage(RecetteBuilder $builder) {
            $nom = $builder->getNomRef();
            $recette = $builder->getRecetteRef();

            $this->title = "Ajouter votre recette";

            $this->content =
            '<form action="'. $this->router->getRecetteSaveURL() . '" method="POST">';
            $this->content .= '<p><label>Nom de la recette :  <br /><input type="text" name="' . $nom .'" placeholder="Entrez ' . $nom . '">';
            $errNom = $builder->getErrors($nom);
		    if ($errNom !== null)
			    $this->content .= ' <span class="error">'. $errNom . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Etapes de la recette :  <br /><textarea name="recette" placeholder="Entrez la ' . $recette . '" rows="15" cols="50"></textarea>';
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>

            <p><input type="submit" value="Envoyer"></p>
            </form>';
        }

        public function makerecetteDeletionPage($id) {   
             
            $this->title = "Suppression de la recette";
            $this->content = "<p>La recette va être supprimée.</p>\n";
            $this->content .= '<form action="'. $this->router->getRecetteDeletionURL($id) .'" method="POST">';
            $this->content .= "<button>Confirmer</button>\n</form>\n";
        }
    
        public function makerecetteDeletedPage() {
            $this->title = "Suppression effectuée";
            $this->content = "<p>La recette a bien été correctement supprimée.</p>";
        }

        public function makerecetteModificationPage(RecetteBuilder $builder, $id) {
            $nom = $builder->getNomRef();
            $recette = $builder->getRecetteRef();

            $this->title = "Modifier la recette";

            $this->content = 
            '<form action="' . $this->router->updateModificationRecette($id) . '" method="POST">';
            $this->content .= '<p><label>Nom de la recette :  <br /><input type="text" name="' . $nom .'" value="' . $builder->getData($nom) . '">';
            $errNom = $builder->getErrors($nom);
		    if ($errNom !== null)
			    $this->content .= ' <span class="error">'. $errNom . '</span>';
            $this->content .='</label></p>';
            
            $this->content .= '<p><label>Etapes de la recette :  <br /><textarea name="recette" rows="15" cols="50">' . $builder->getData($recette) . '</textarea>';
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>

            <button>Modifier</button></form>';
        }

        /*protected function getMenu() {
            return array(
                "Accueil" => $this->router->homePage(),
                "La liste des Recettes" => $this->router->listeRecettesPage(),
                "Ajouter une nouvelle recette" => $this->router->getRecetteCreationURL(),
            );
        }*/

        protected function getMenu(){
            return array(
                "LOGO" => '#',//image
                "<input type='text' placeholder='Search...(En option)'>" => '#',
                "Se Connecter" => $this->router->getFormulaireConnexionURL(),
            );
        }

        //mettre l'option ajouter new recette dans le content de la page liste recettes
        protected function getSousMenu(){
            return array(
                "Accueil" => $this->router->homePage(),
                "La liste des Recettes" => $this->router->listeRecettesPage(),
                "Ajouter une nouvelle recette" => $this->router->getRecetteCreationURL(),
            );
        }

        public function makeConnexionPage(){
            $this->title = "Se connecter";

            $this->content = 
            '<form action="' . $this->router->getConnexionURL() . '" method="POST">
            
            <label><b>Utilisateur</b></label><br />
            <input type="text" placeholder="Entrez utilisateur" name="username" required><br />

            <label><b>Mot de passe</b></label><br />
            <input type="password" placeholder="Entrer le mot de passe" name="password" required><br />

            <input type="submit" id="submit" value="Se connecter" >
            </form>';
            /*
            a placer entre le input et le /form pour verifier si le mdp est correcte mais pas besoin
            if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1 || $err==2)
                    echo '<p style="color:red">Utilisateur ou mot de passe incorrect</p>';
            }*/
        }

    
    }
?>