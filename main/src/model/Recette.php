<?php
    class Recette{
        public $nom;
        public $prenom;
        public $titre;
        public $recette;
        public $photos;

        public function __construct($nom, $prenom, $titre, $recette, $photos) {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->titre = $titre;
            $this->recette = $recette;
            $this->photos = $photos;
        }

        //Accesseurs
        public function getNom() { 
            return $this->nom; 
        }
        public function getPrenom() { 
            return $this->prenom; 
        }
        public function getTitre() { 
            return $this->titre; 
        }
        public function getRecette() { 
            return $this->recette; 
        }
        public function getPhotos() {
            return $this->photos;
        }

        //Mutateurs
        public function setNom($nom) {
            if (!self::isNomValid($nom))
                throw new Exception("Le nom n'est pas valide");
            $this->nom = $nom;
        }

        public function setPrenom($prenom) {
            if (!self::isPrenomValid($prenom))
                throw new Exception("Le prenom n'est pas valide");
            $this->prenom = $prenom;
        }

        public function setTitre($titre) {
            if (!self::isTitreValid($titre))
                throw new Exception("Le titre n'est pas valide");
            $this->titre = $titre;
        }

        public function setRecette($recette) {
            if (!self::isRecetteValid($recette))
                throw new Exception("La recette n'existe pas");
            $this->recette = $recette;
        }
        public function setPhotos($photos) {
            if (!self::isPhotosValid($photos))
                throw new Exception("La photo n'existe pas");
            $this->photos = $photos;
        }

        //Verification
        public static function isNomValid($nom) {
            return $nom !== "";
        }

        public static function isPrenomValid($prenom) {
            return $prenom !== "";
        }

        public static function isTitreValid($titre) {
            return $titre !== "";
        }        

        public static function isRecetteValid($recette) {
            return $recette !== "";
        }
        public static function isPhotosValid($photos) {
            return $photos !== "";
        }
    }
?>
