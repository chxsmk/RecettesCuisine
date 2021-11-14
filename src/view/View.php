<?php
require_once("model/Recette.php");
require_once("model/RecetteBuilder.php");

class View
{
    protected $title;
    protected $content;
    protected $nom;
    protected $recette;
    protected $router;

    public function __construct(Router $router)
    {
        $this->title = null;
        $this->nom = null;
        $this->recette = null;
        $this->content = null;
        $this->router = $router;
    }

    public function render()
    {
        include "squelette.php";
    }

    public function makeHomePage($tableau)
    {
        if (key_exists('username', $_SESSION)) {
            $this->title = "Bienvenue " . $_SESSION['username'] . " !";
        } else {
            $this->title = "Bienvenue !";
        }
        $this->content = "<p>Voici la liste de nos dernières recettes !</p>";
        $this->content .= "<div class='listeRecettes'>";
        foreach ($tableau as $key => $value) {
            $this->content .= "<figure class='recette'>";
            $id = $this->router->getRecetteURL($value['id']);
            $this->content .= '<img src="imagesUsers/' . $value['image'] . '" name="image" alte="image de la recette">';
            $this->content .= "<figcaption><a href='" . $id . "'>" . $value['titre'] . "</a></figcaption>";
            $this->content .= "</figure>";
        }
        $this->content .= "</div>";
    }

    public function makeRecettePage(Recette $recette, $id)
    {
        $this->title = 'Une recette écrite par : ' . $recette->getUtilisateur();
        $this->content = '<h3> Recette pour : ' . $recette->getTitre() . '</h3>';
        $this->content .= '<p> Voici la recette : <br />' . $recette->getRecette() . '</p>';
        $this->content .= '<img src="imagesUsers/' . $recette->getImage() . '" name="image"><br />';
        if ($_SESSION['username'] == $recette->getUtilisateur() || $_SESSION['username'] == 'admin') {
            $this->content .= '<a href="' . $this->router->getRecetteAskDeletionURL($id) . '"> Supprimer la recette </a><br />';
            $this->content .= '<a href="' . $this->router->getRecetteModificationURL($id) . '"> Modifier la recette </a><br />';
        }
    }

    public function makeSearchPage($tableau)
    {
        if (key_exists('recherche', $_GET)) {
            $this->title = "Recherche pour :";
            $this->content = "<h3>" . $_GET['recherche'] . "</h3>";
            $this->content .= "<ul>";
            foreach ($tableau as $key => $value) {
                $id = $this->router->getRecetteURL($value['id']);
                $this->content .= "<li><a href='" . $id . "'>" . $value['titre'] . "</a></li>";
            }
            $this->content .= "</ul>";
        }
    }

    public function makeUnknownSearchPage()
    {
        $this->title = "Recherche";
        $this->content = "<h3>" . $_GET['recherche'] . "</h3>";
        $this->content .= "<p>Désolée, aucune recette ne correspond à votre recherche !</p>";
    }

    public function makeUnknownRecettePage()
    {
        $this->title = "Erreur";
        $this->content = "<p> La page demandée n'existe pas. </p>";
    }

    public function makeUnknownUserPage()
    {
        $this->title = "Erreur";
        $this->content = "<p> L'utilisateur saisi n'existe pas. </p>";
    }

    public function makeNoUserPage()
    {
        $this->title = "Vous n'êtes pas connecté !";

        $this->content =
            '<p>Vous devez vous connecter ou vous inscrire.</p>
        <ul>
            <li><a href="' . $this->router->getConnexionFormURL() . '">Connexion</a></li>
            <li><a href="' . $this->router->getIncriptionFormURL() . '">Inscription</a></li>
        </ul>';
    }

    public function makeNoAdminPage()
    {
        $this->title = "Vous n'êtes pas administrateur! Accès non autorisé.";
    }

    public function makeAdminPage($users)
    {
        $this->title = "Espace administrateur";
        $this->content .= "<h3>Utilisateurs enregistrés</h3>";
        $this->content .= "<div class='listeUtilisateurs'><ul>";
        foreach ($users as $key => $value) {
            if ($value['utilisateur'] != 'admin') {
                $this->content .= "<li>" . $value['utilisateur'] . "</li>";
            }
        }
        $this->content .= "</ul></div>";
        $this->content .= '<a href="' . $this->router->getUserAskDeletionURL() . '"> Supprimer un utilisateur</a><br />';
    }

    public static function makeConnexionForm()
    {
        $content = '<label><b>Utilisateur</b></label><br />
        <input type="text" placeholder="Entrez utilisateur" name="username" required><br />
        <label><b>Mot de passe</b></label><br />
        <input type="password" placeholder="Entrer le mot de passe" name="password" required><br />';
        return $content;
    }

    public function makeInscriptionPage()
    {
        $this->title = "Inscription";
        $this->content = '<form action="' . $this->router->getInscritionURL() . '" method="POST">';
        $this->content .= self::makeConnexionForm();
        $this->content .= '<input type="submit" id="submit" value="Créer" ></form>';
    }

    public function makeAutreNomPage()
    {
        $this->title = "Inscription";
        $this->content = "Vous ne pouvez pas choisir ce nom d'utilisateur :<br />";
        $this->content .= '<form action="' . $this->router->getInscritionURL() . '" method="POST">';
        $this->content .= self::makeConnexionForm();
        $this->content .= '<input type="submit" id="submit" value="Créer" ></form>';
    }

    public function makeExistComptePage()
    {
        $this->title = "Inscription";
        $this->content = "Le compte existe déjà. Veuillez choisir un autre nom d'utilisateur ou mot de passe :<br />";
        $this->content .= '<form action="' . $this->router->getInscritionURL() . '" method="POST">';
        $this->content .= self::makeConnexionForm();
        $this->content .= '<input type="submit" id="submit" value="Créer" ></form>';
    }

    public function makeConnexionPage()
    {
        $this->title = "Se connecter";
        $this->content = '<form action="' . $this->router->getConnexionURL() . '" method="POST">';
        $this->content .= self::makeConnexionForm();
        $this->content .= '<input type="submit" id="submit" value="Se connecter" > </form>';
    }

    public function makeUserDeletionPage()
    {
        $this->title = "Supprimer un utilisateur";
        $this->content = '<form action="' . $this->router->getUserDeletionURL() . '" method="POST">
        <label><b>Entrez un utilisateur à supprimer</b></label><br />
        <input type="text" placeholder="Utilisateur" name="utilisateur" required><br />
        <input type="submit" id="submit" value="Supprimer" > 
        </form>';
    }

    public function makeUserDeletedPage()
    {
        $this->title = "Suppression de l'utilisateur effectuée";
        $this->content = "<p>L'utilisateur a bien été supprimé.</p>";
    }

    public static function makeRecetteForm(RecetteBuilder $builder)
    {
        $utilisateurRecette = $builder->getUtilisateurRef();
        $titreRecette = $builder->getTitreRef();
        $recette = $builder->getRecetteRef();
        $imageRecette = $builder->getImageRef();

        $content = '<p><label>Votre nom utilisateur :  <br /><input type="text" name="' . $utilisateurRecette . '" placeholder="Entrez votre ' . $utilisateurRecette . '" value="' . $builder->getData($utilisateurRecette) . '">';
        $errUtulisateur = $builder->getErrors($utilisateurRecette);
        if ($errUtulisateur !== null) {
            $content .= ' <span class="error">' . $errUtulisateur . '</span>';
        }
        $content .= '</label></p>';

        $content .= '<p><label>Nom de la recette :  <br /><input type="text" name="' . $titreRecette . '" placeholder="Entrez ' . $titreRecette . '" value="' . $builder->getData($titreRecette) . '">';
        $errTitre = $builder->getErrors($titreRecette);
        if ($errTitre !== null) {
            $content .= ' <span class="error">' . $errTitre . '</span>';
        }
        $content .= '</label></p>';

        $content .= '<p><label>Etapes de la recette :  <br /><textarea name="' . $recette . '" placeholder="Entrez la ' . $recette . '" rows="15" cols="50">' . $builder->getData($recette) . '</textarea>';
        $errRecette = $builder->getErrors($recette);
        if ($errRecette !== null) {
            $content .= ' <span class="error">' . $errRecette . '</span>';
        }
        $content .= '</label></p>';

        $content .= '<p><label>Choisissez le fichier image (JPEG ou PNG) : <input type="file" name="' . $imageRecette . '" accept="image/png, image/jpeg">' .
            $errImage = $builder->getErrors($imageRecette);
        if ($errImage !== null) {
            echo "to";
            $content .= ' <span class="error">' . $errImage . '</span>';
        }
        $content .= '</label></p>';
        return $content;
    }

    public function makeRecetteCreationPage(RecetteBuilder $builder)
    {
        $this->title = "Ajouter votre recette";
        $this->content .= '<form enctype="multipart/form-data" action="' . $this->router->getRecetteSaveURL() . '" method="POST">';
        $this->content .= self::makeRecetteForm($builder);
        $this->content .= '<button>Créer</button></form>';
    }

    public function makeRecetteModificationPage(RecetteBuilder $builder, $id)
    {
        $this->title = "Modifier la recette";
        $this->content = '<form enctype="multipart/form-data" action="' . $this->router->updateModificationRecette($id) . '" method="POST">';
        $this->content .= self::makeRecetteForm($builder);
        $this->content .= '<button>Modifier</button></form>';
    }

    public function makeRecetteDeletionPage($id)
    {
        $this->title = "Suppression de la recette";
        $this->content = "<p>La recette va être supprimée.</p>";
        $this->content .= '<form action="' . $this->router->getRecetteDeletionURL($id) . '" method="POST">';
        $this->content .= "<button>Confirmer</button></form>";
    }

    public function makeRecetteDeletedPage()
    {
        $this->title = "Suppression effectuée";
        $this->content = "<p>La recette a bien été correctement supprimée.</p>";
    }

    public function makeAProposPage()
    {
        $this->title = "À propos de nous";
        $this->content = "<p>Nous sommes le groupe 25. Notre groupe est composé de : Manon JAMES (22000089) et de Chamora SAMAKON (21903735).</p>";

        $this->content .= "<h3>Notre site :</h3>";
        $this->content .= "<p>Lors de ce projet, nous devions faire un site qui utilise l'architecture MVCR que nous avons vu en cours et en TP.
        Nous avons décidé de faire un site de recettes de cuisine.
        Nous avons donc décidé de reprendre le TP concernant les animaux, réalisé précédemment, en l'adaptant de façon à ce qu'il corresponde aux besoins de notre projet. <br /></p>";

        $this->content .= "<h3>Les points réalisés :</h3>";
        $this->content .= "<p>Lors de ce projet, nous devions faire un site qui utilise l'architecture MVCR que nous avons vu en cours et en TP.
        Nous avons donc décidé de reprendre le TP concernant les animals réalisé précédemment, en l'adaptant de façon à ce qu'il corresponde aux besoins de notre projet. <br /></p>";
        $this->content .= "<p>En ce qui concerne les compléments nous devions en choisir 3 parmis la liste ci-dessous :</p>
        <ol>
            <li>(*) Une recherche d'objets.</li>
            <li>Associer des images aux objets (en choisir un seul parmi les trois) :
                <ol>
                    <li>(*) Un objet peut être illustré par une image (et une seule, non modifiable) uploadée par le créateur de l'objet.</li>
                    <li>(***) Un objet peut être illustré par zéro, une ou plusieurs images (modifiables) uploadées par le créateur de l'objet.</li>
                    <li>(****) Un objet peut être illustré par une (ou plusieurs) images (modifiables), uploadées par le créateur de l'objet et l'upload de cette image aura une barre de progression.</li>
                </ol>
            </li>
            <li>(**) Site responsive</li>
            <li>(*) Tri de la liste des objets (par date etc).</li>
            <li>(*) Gestion par un admin des comptes utilisateurs.</li>
            <li>(**) Pagination de la liste (avec N objets par page).</li>
            <li>(***) Commentaires sur un objet.</li>
            <li>(**) Dans le formulaire d'inscription, vérification en temps réel de la disponibilité du login (par exemple lorsque le focus quitte le champ login).</li>
            <li>(***) Fonctionnalité rester connecté, avec une durée de validité (plusieurs jours par exemple) paramétrable par l'administrateur du site.</li>
        </ol>
        <p>Nous avons donc choisi : </p>
        <p>Une recherche d'objets. (1), Gestion par un admin (6) et  Associer des images aux objets(2.2).</p>";

        $this->content .= "<h3>La répartition des tâches :</h3>";
        $this->content .= "<p>Les TPs concernant la création d'un site web sur les animaux nous ont beaucoup servi.
        Etant donné que Chamora avait terminé tout le TP concernant le site des animaux, nous avons repris sa version et l'avons adapté de façon à ce qu'elle corresponde au site que nous voulions faire.<br />
        De ce fait, il ne nous restait plus que l'authentification des utilisateurs et les compléments à réaliser. <br />Chamora s'est occupée de la barre de recherche. <br />Manon s'est occupée de la partie administrateur.
        <br />Concernant l'upload d'images, cela s'est fait à 2 : nous voulions à la base les stocker au format blob dans notre base de données, ce que Manon a essayé à maintes reprises en vain. Chamora a donc eu l'idée
        de stocker les images dans un dossier upload, plutôt que de les stocker dans la bd, et de stocker leur adresse et nom dans la BDD à la place, ce qui a fonctionnée. Pour le CSS, nous avons chacune apporté notre touche à tour de rôle.</p>";

        $this->content .= "<h3>Quelques explications concernant nos choix en matière de design, modélisation, code, etc... :</h3>";
        $this->content .= "<p>Notre site étant un site culinaire, partageant des recettes de cuisine, les internautes ont la possibilité de se créer un compte
        afin de publier leurs propres recettes. <br />L'utilisateur ayant publié la recette peut la modifier au gré de ses envies ainsi que la supprimer s'il le souhaite. Il ne peut agir que sur
        les siennes, mais n'a pas de pouvoir sur les recettes des autres utilisateurs. <br />Certains utilisateurs peuvent avoir plus de pouvoir s'ils font parti des administrateurs. Les administrateurs ont un espace dédié, l'Espace Administrateur. Ils ont le pouvoir de modifier
        ou supprimer n'importe quelle recette depuis la page de celle-ci. Il ont aussi accès à la gestion des comptes utilisateurs, et peuvent les supprimer depuis leur Espace Administrateur.</p>";
    }
}
