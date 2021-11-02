<?php

    session_start();
    require_once("RecetteStorage.php");

    class RecetteStorageMySQL implements RecetteStorage{
        protected $db;
        
        public function __construct($db) {
            $this->db = $db;
        }

        public function read($id){
            $requete = $this->db->prepare('SELECT * FROM recettes WHERE id= :id');
            $requete->execute([":id" => $id]);
            $resultat = $requete->fetch();
            if($resultat!==false){
                $recette = new Recette($resultat['nom'], $resultat['prenom'], $resultat['titre'], $resultat['recette']);
                return $recette;
            }
            else{
                return null;
            } 
        }

        public function readAll(){
            $requete = $this->db->query('SELECT * FROM recettes');
            $resultat = $requete->fetchAll();
            return $resultat;
        }

        public function create(Recette $recette){
            $requete = $this->db->prepare('INSERT INTO recettes (nom, prenom, titre, recette) VALUES (:nom, :prenom, :titre, :recette)');
            $requete->execute(array(":nom" => $recette->getNom(), ":prenom" => $recette->getPrenom(), ":titre" => $recette->getTitre(), ":recette" => $recette->getRecette()));
            return $this->db->lastInsertId();
        }

        public function search($recherche){
            $requete =  $this->db->prepare('SELECT * FROM recettes WHERE titre LIKE :titre ORDER BY id DESC');
            $requete->execute([":titre" => "%" . $recherche . "%"]);
            $resultat = $requete->fetchAll();
            return $resultat;
        }

        public function delete($id){
            $requete = $this->db->prepare('DELETE FROM recettes WHERE id= :id');
            return $requete->execute([":id" => $id]);
        }

        public function update(Recette $recette, $id) {
            $requete = $this->db->prepare('UPDATE recettes SET nom= :nom, prenom= :prenom, titre= :titre, recette= :recette WHERE id= :id');
            return $requete->execute(array(":nom" => $recette->getNom(), ":prenom" => $recette->getPrenom(), ":titre" => $recette->getTitre(), ":recette" => $recette->getRecette(), "id" => $id));
        }

        //vélifie si les données entrées par l'utilisateur sont dans la bd.
        //A revoir
        //enlever le startSession si n'utilise pas
        public function verifieConnexion($data){
            $requete = $this->db->prepare('SELECT * FROM users WHERE utilisateur= :utilisateur AND mdp= :mdp');
            $requete->execute(array(":utilisateur" => $data['username'],":mdp" => $data['password']));

            /*
            $utilisateur = $data['username'];
            $mdp = $data['password'];
            $requete ='SELECT * FROM users WHERE utilisateur= "' . $utilisateur . '" AND mdp= "' . $mdp . '"');
            $requete= $this->db->query($utilisateur, $mdp);
            $reponse =  $this->db->fetch_array($requete);
            $count = $reponse['count(*)'];
            if($count!=0){
                $_SESSION['username'] = $data['username'];
                header('Location: recettes.php');
            }
            else{
                header('Location: login.php?erreur=1');
            }
            */
        }
    }
?>
       
