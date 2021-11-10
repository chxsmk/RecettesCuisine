<?php

session_start();
require_once("RecetteStorage.php");

class RecetteStorageMySQL implements RecetteStorage
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function read($id)
    {
        $requete = $this->db->prepare('SELECT * FROM recettes WHERE id= :id');
        $requete->execute([":id" => $id]);
        $resultat = $requete->fetch();
        if ($resultat !== false) {
            $recette = new Recette($resultat['utilisateur'], $resultat['titre'], $resultat['recette'], $resultat['image']);
            return $recette;
        } else {
            return null;
        }
    }

    public function readAll()
    {
        $requete = $this->db->query('SELECT * FROM recettes');
        $resultat = $requete->fetchAll();
        return $resultat;
    }

    public function create(Recette $recette)
    {
        $requete = $this->db->prepare('INSERT INTO recettes (utilisateur, titre, recette, image) VALUES (:utilisateur, :titre, :recette, :image)');
        $requete->execute(array(":utilisateur" => $recette->getUtilisateur(),  ":titre" => $recette->getTitre(), ":recette" => $recette->getRecette(), ":image" => addslashes($recette->getImage())));
        return $this->db->lastInsertId();
    }

    public function search($recherche)
    {
        $requete =  $this->db->prepare('SELECT * FROM recettes WHERE titre LIKE :titre ORDER BY id DESC');
        $requete->execute([":titre" => "%" . $recherche . "%"]);
        $resultat = $requete->fetchAll();
        return $resultat;
    }

    public function delete($id)
    {
        $requete = $this->db->prepare('DELETE FROM recettes WHERE id= :id');
        return $requete->execute([":id" => $id]);
    }

    public function update(Recette $recette, $id)
    {
        $requete = $this->db->prepare('UPDATE recettes SET utilisateur= :utilisateur, titre= :titre, recette= :recette, image= :image WHERE id= :id');
        return $requete->execute(array(":utilisateur" => $recette->getUtilisateur(), ":titre" => $recette->getTitre(), ":recette" => $recette->getRecette(), ":image" => $recette->getImage(), "id" => $id));
    }

    /*Gestion de mot passe :
    encryter : $hash = passeword_hash('mdp',PASSEWORD);
    vérif/décrypter : password_verify($_POST['password'],$hash);
    */

    public function addNewIncription($data)
    {
        $requete = $this->db->prepare('INSERT INTO users (utilisateur, mdp) VALUES (:utilisateur, :mdp)');

        $requete->execute(array(":utilisateur" => $data['username'], ":mdp" => $data['password']));
        return $this->db->lastInsertId();
    }

    public function verification($data)
    {
        $requete = $this->db->prepare('SELECT * FROM users WHERE utilisateur= :utilisateur AND mdp= :mdp');
        $requete->execute(array(":utilisateur" => $data['username'], ":mdp" => $data['password']));

        //renvoie tab null si false ou la ligne user si true
        $resultat = $requete->fetch();
        return $resultat;

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
