<?php
    require_once("Recette.php");

    class RecetteBuilder{
        protected $data;
	    protected $errors;

        public function __construct($data) {
            if ($data === null) {
                $data = array(
                    "nom" => "",
                    "prenom" => "",
                    "titre" => "",
                    "recette" => "",
                    "photos" => "",
                );
            }
            $this->data = $data;
            $this->errors = array();
        }

        public function createRecette(){

          $photo = isset($_FILES[$this->data['photos']]['tmp_name'])? $_FILES[$this->data['photos']]['tmp_name'] : NULL;
          if(!key_exists("nom", $this->data) || !key_exists("prenom", $this->data) || !key_exists("titre", $this->data) || !key_exists("recette", $this->data)|| !key_exists("photos", $this->data)){
			    throw new Exception("Il manque un paramètre pour créer une recette !");
          }
            $photo=file_get_contents($photo);
            $photo=addslashes($photo);

            return new Recette($this->data['nom'],$this->data['prenom'],$this->data['titre'], $this->data['recette'], $photo);
        }

        public function isValid() {
            $this->errors = array();
            if (!key_exists("nom", $this->data) || $this->data["nom"] === ""){
                $this->errors["nom"] = "Vous devez entrer un nom !";
            }
            if (!key_exists("prenom", $this->data) || $this->data["prenom"] === ""){
                $this->errors["prenom"] = "Vous devez entrer un prenom !";
            }
            if (!key_exists("titre", $this->data) || $this->data["titre"] === ""){
                $this->errors["titre"] = "Vous devez entrer un titre !";
            }
            if (!key_exists("recette", $this->data) || $this->data["recette"] === ""){
                $this->errors["recette"] = "Vous devez entrer la recette !";
            }
            if (!key_exists("photos", $this->data) || $this->data["photos"] === ""){
                $this->errors["photos"] = "Vous devez uploader une photo !";
            }
            return count($this->errors) === 0;
        }

        public function getNomRef() {
            return "nom";
        }

        public function getPrenomRef() {
            return "prenom";
        }

        public function getTitreRef() {
            return "titre";
        }

        public function getRecetteRef() {
            return "recette";
        }

        public function getPhotosRef() {
            return "photos";
        }

        public function getErrors($ref) {
            return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
        }

        public function updateRecette(Recette $recette) {
            if (key_exists("nom", $this->data)){
                $recette->setNom($this->data["nom"]);
            }
            if (key_exists("prenom", $this->data)){
                $recette->setPrenom($this->data["prenom"]);
            }
            if (key_exists("titre", $this->data)){
                $recette->setTitre($this->data["titre"]);
            }
            if (key_exists("recette", $this->data)){
                $recette->setRecette($this->data["recette"]);
            }
            if (key_exists("photos", $this->data)){
                $recette->setPhotos($this->data["photos"]);
            }
        }

        public function getData($ref){
            if(key_exists($ref, $this->data)){
                return $this->data[$ref];
            }
            else{
                return null;
            }
        }

        public function buildFromRecette(recette $recette){
            $data = array(
                'nom' => $recette->getNom(),
                'prenom' => $recette->getPrenom(),
                'titre' => $recette->getTitre(),
                'recette' => $recette->getRecette()
                //'photos' => $recette->getPhotos(),
            );
            return new self($data);
        }
    }
?>
