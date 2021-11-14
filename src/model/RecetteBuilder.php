<?php
require_once("Recette.php");

class RecetteBuilder
{
    protected $data;
    protected $errors;

    public function __construct($data)
    {
        if ($data === null) {
            $data = array(
                "utilisateur" => "",
                "titre" => "",
                "recette" => "",
                "image" => "",
            );
        }
        $this->data = $data;
        $this->errors = array();
    }

    public function createRecette()
    {
        $nomImg = uniqid() . $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], "upload/" . $nomImg)) {
            $this->data["image"] = $nomImg;
        }

        if (!key_exists("utilisateur", $this->data) || !key_exists("titre", $this->data) || !key_exists("recette", $this->data)) {
            throw new Exception("Il manque un paramètre pour créer une recette !");
        }
        return new Recette($this->data['utilisateur'], $this->data['titre'], $this->data['recette'], $this->data['image']);
    }

    public function isValid()
    {
        $this->errors = array();
        if (!key_exists("utilisateur", $this->data) || $this->data["utilisateur"] === "" || ($_SESSION['username'] != 'admin' && $this->data['utilisateur'] != $_SESSION['username'])) {
            $this->errors["utilisateur"] = "Veuillez entrer votre nom d'utilisateur !";
        }
        if (!key_exists("titre", $this->data) || $this->data["titre"] === "") {
            $this->errors["titre"] = "Veuillez entrer un titre !";
        }
        if (!key_exists("recette", $this->data) || $this->data["recette"] === "") {
            $this->errors["recette"] = "Veuillez entrer la recette !";
        }
        return count($this->errors) === 0;
    }

    public function getUtilisateurRef()
    {
        return "utilisateur";
    }

    public function getTitreRef()
    {
        return "titre";
    }

    public function getRecetteRef()
    {
        return "recette";
    }

    public function getImageRef()
    {
        return "image";
    }

    public function getErrors($ref)
    {
        return key_exists($ref, $this->errors) ? $this->errors[$ref] : null;
    }

    public function updateRecette(Recette $recette)
    {
        if (key_exists("utilisateur", $this->data)) {
            $recette->setUtilisateur($this->data["utilisateur"]);
        }
        if (key_exists("titre", $this->data)) {
            $recette->setTitre($this->data["titre"]);
        }
        if (key_exists("recette", $this->data)) {
            $recette->setRecette($this->data["recette"]);
        }
        if (key_exists("image", $this->data)) {
            $recette->setImage($this->data["image"]);
        }
    }

    public function getData($ref)
    {
        if (key_exists($ref, $this->data)) {
            return $this->data[$ref];
        } else {
            return null;
        }
    }

    public function buildFromRecette(recette $recette)
    {
        $data = array(
            'utilisateur' => $recette->getUtilisateur(),
            'titre' => $recette->getTitre(),
            'recette' => $recette->getRecette(),
            'image' => $recette->getImage()

        );
        return new self($data);
    }
}
