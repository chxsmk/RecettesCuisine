<?php
    class Recette{
        public $nom;
        public $recette;

        public function __construct($nom, $recette) {
            $this->nom = $nom;
            $this->recette = $recette;
        }

        //Accesseurs
        public function getNom() { 
            return $this->nom; 
        }
        public function getRecette() { 
            return $this->recette; 
        }

        //Mutateurs
        public function setNom($nom) {
            if (!self::isNomValid($nom))
                throw new Exception("Le nom n'est pas valide");
            $this->nom = $nom;
        }

        public function setRecette($recette) {
            if (!self::isRecetteValid($recette))
                throw new Exception("La recette n'existe pas");
            $this->recette = $recette;
        }

        //Verification
        public static function isNomValid($nom) {
            return $nom !== "";
        }

        public static function isRecetteValid($recette) {
            return $recette !== "";
        }
    }
?>