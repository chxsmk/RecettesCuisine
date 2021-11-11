<?php
class Recette
{
    public $utilisateur;
    public $titre;
    public $recette;
    public $image;

    public function __construct($utilisateur, $titre, $recette, $image)
    {
        $this->utilisateur = $utilisateur;
        $this->titre = $titre;
        $this->recette = $recette;
        $this->image = $image;
    }

    //Accesseurs
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
    public function getTitre()
    {
        return $this->titre;
    }
    public function getRecette()
    {
        return $this->recette;
    }
    public function getImage()
    {
        return $this->image;
    }

    //Mutateurs
    public function setUtilisateur($utilisateur)
    {
        if (!self::isUtilisateurValid($utilisateur))
            throw new Exception("Le nom utilisateur n'est pas valide");
        $this->utilisateur = $utilisateur;
    }

    public function setTitre($titre)
    {
        if (!self::isTitreValid($titre))
            throw new Exception("Le titre n'est pas valide");
        $this->titre = $titre;
    }

    public function setRecette($recette)
    {
        if (!self::isRecetteValid($recette))
            throw new Exception("La recette n'existe pas");
        $this->recette = $recette;
    }

    public function setImage($image)
    {
        if (!self::isImageValid($image))
            throw new Exception("L'image n'existe pas");
        $this->Image = $image;
    }

    //Verification
    public static function isUtilisateurValid($utilisateur)
    {
        return $utilisateur !== "";
    }

    public static function isTitreValid($titre)
    {
        return $titre !== "";
    }

    public static function isRecetteValid($recette)
    {
        return $recette !== "";
    }

    public static function isImageValid($image)
    {
        return $image !== "";
    }
}
