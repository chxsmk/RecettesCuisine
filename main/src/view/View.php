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

        public function makeHomePage($tableau){
            $this->title = "Bienvenue !";
            $this->content = "<p>Dernières recettes</p>";
            $this->content .= "<ul>";
            foreach($tableau as $key=>$value){
                $id = $this->router->getRecetteURL($value['id']);
                $this->content .= "<a href='" . $id . "'>" . $value['titre'] . "</a><br />";
            }
            $this->content .= "</ul>";

        }

        public function makeRecettePage(Recette $recette, $id){
            $this->title = "Une recette écrite par : " . $recette->getNom() . " " . $recette->getPrenom();
            $this->content = "<h3> Recette pour : " . $recette->getTitre() . "</h3>";
            $this->content .= "<p> Voici la recette : <br /> " . $recette->getRecette() . "</p>";
            $this->content .= "<p> Voici une photo de celle-ci:</p>";
            //$this->content .= "<a href='" . $this->router->getRecetteAskDeletionURL($id) . "'> Supprimer la recette </a><br />";
            //$this->content .= "<a href='" . $this->router->getRecetteModificationURL($id) . "'> Modifier la recette </a><br />";
        }

        public function makeRecetteUserPage(Recette $recette, $id){
            $this->makeRecettePage($recette, $id);
            $this->content .= "<a href='" . $this->router->getRecetteAskDeletionURL($id) . "'> Supprimer la recette </a><br />";
            $this->content .= "<a href='" . $this->router->getRecetteModificationURL($id) . "'> Modifier la recette </a><br />";
        }

        public function makeUnknownRecettePage(){
            $this->title = "Erreur";
		    $this->content = "<p> La page demandée n'existe pas. </p>";
        }

        public function makeDebugPage($variable) {
            $this->title = 'Debug';
            $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
        }

        public function makeSearchPage($tableau){
            if(key_exists('recherche',$_GET)){
                $this->title = "Recherche pour :";
                $this->content = "<h2>" . $_GET['recherche'] . "</h2>";
                $this->content .= "<ul>";
                foreach($tableau as $key=>$value){
                    $id = $this->router->getRecetteURL($value['id']);
                    $this->content .= "<a href='" . $id . "'>" . $value['titre'] . "</a><br />";
                }
                $this->content .= "</ul>";
            }
        }

        public function makeUnknownSearchPage(){
            $this->title = "Recherche";
            $this->content = "<p>Aucune recette ne correspond à votre recherche !</p>";
        }

        public function makeRecetteCreationPage(RecetteBuilder $builder) {
            $nomRecette = $builder->getNomRef();
            $prenomRecette = $builder->getPrenomRef();
            $titreRecette = $builder->getTitreRef();
            $recette = $builder->getRecetteRef();
            $photosRecette= $builder->getPhotosRef();

            $this->title = "Ajouter votre recette";

            $this->content =
            '<form action="' . $this->router->getRecetteSaveURL() . '" method="POST">';
            $this->content .= '<p><label>Votre nom :  <br /><input type="text" name="' . $nomRecette . '" placeholder="Entrez votre ' . $nomRecette . '">';
            $errNom = $builder->getErrors($nomRecette);
            if ($errNom !== null)
			    $this->content .= ' <span class="error">'. $errNom . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Votre prénom :  <br /><input type="text" name="' . $prenomRecette . '" placeholder="Entrez votre ' . $prenomRecette .'">';
            $errPrenom = $builder->getErrors($titreRecette);
            if ($errPrenom !== null)
			    $this->content .= ' <span class="error">'. $errPrenom . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Nom de la recette :  <br /><input type="text" name="' . $titreRecette . '" placeholder="Entrez ' . $titreRecette . '">';
            $errTitre = $builder->getErrors($titreRecette);
		    if ($errTitre !== null)
			    $this->content .= ' <span class="error">'. $errTitre . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Etapes de la recette :  <br /><textarea name="' . $recette . '" placeholder="Entrez la ' . $recette . '" rows="15" cols="50"></textarea>';
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Photos de la recette: <input type="file" name="'.$photosRecette.'" size=50>'.
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>';

            '<p><input type="submit" value="Envoyer"></p>
            </form>';
        }

        public function makeRecetteDeletionPage($id) {

            $this->title = "Suppression de la recette";
            $this->content = "<p>La recette va être supprimée.</p>\n";
            $this->content .= '<form action="'. $this->router->getRecetteDeletionURL($id) .'" method="POST">';
            $this->content .= "<button>Confirmer</button>\n</form>\n";
        }

        public function makeRecetteDeletedPage() {
            $this->title = "Suppression effectuée";
            $this->content = "<p>La recette a bien été correctement supprimée.</p>";
        }

        public function makeRecetteModificationPage(RecetteBuilder $builder, $id) {
            $nomRecette = $builder->getNomRef();
            $prenomRecette = $builder->getPrenomRef();
            $titreRecette = $builder->getTitreRef();
            $recette = $builder->getRecetteRef();
            $photosRecette= $builder->getPhotosRef();

            $this->title = "Modifier la recette";

            $this->content =
            '<form action="' . $this->router->updateModificationRecette($id) . '" method="POST">';
            $this->content .= '<p><label>Votre nom :  <br /><input type="text" name="' . $nomRecette .'" value="' . $builder->getData($nomRecette) . '">';
            $errNom = $builder->getErrors($nomRecette);
            if ($errNom !== null)
			    $this->content .= ' <span class="error">'. $errNom . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Votre prénom :  <br /><input type="text" name="' . $prenomRecette .'" value="' . $builder->getData($prenomRecette) . '">';
            $errPrenom = $builder->getErrors($titreRecette);
            if ($errPrenom !== null)
			    $this->content .= ' <span class="error">'. $errPrenom . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Nom de la recette :  <br /><input type="text" name="' . $titreRecette .'" value="' . $builder->getData($titreRecette) . '">';
            $errTitre = $builder->getErrors($titreRecette);
		    if ($errTitre !== null)
			    $this->content .= ' <span class="error">'. $errTitre . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Etapes de la recette :  <br /><textarea name="recette" rows="15" cols="50">' . $builder->getData($recette) . '</textarea>';
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>';

            $this->content .= '<p><label>Photos de la recette: <input type="file" name="'.$photosRecette.'" size=50>'.
            $errRecette = $builder->getErrors($recette);
            if ($errRecette !== null)
                $this->content .= ' <span class="error">'. $errRecette . '</span>';
            $this->content .='</label></p>';

            '<button>Modifier</button></form>';
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

        //mettre l'option ajouter new recette dans le content de la page liste recettes
        /*protected function getSousMenu(){
            return array(
                "Ajouter une nouvelle recette" => $this->router->getRecetteCreationURL(),
                "Modifier une recette" => $this->router->homePage(),
                "Supprimer une recette" => $this->router->getRecetteAskDeletionURL(),
            );
        }*/



    }
?>
