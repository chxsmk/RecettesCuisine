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
        $mdp = password_hash($data['password'], PASSWORD_DEFAULT);
        $requete = $this->db->prepare('INSERT INTO users (utilisateur, mdp) VALUES (:utilisateur, :mdp)');

        $requete->execute(array(":utilisateur" => $data['username'], ":mdp" => $mdp));
        return $this->db->lastInsertId();
    }

    public function verification($data)
    {
        $requete = $this->db->prepare('SELECT mdp FROM users WHERE utilisateur= :utilisateur');
        $requete->execute(array(":utilisateur" => $data['username']));
        $resultat = $requete->fetch();
        if ($resultat) {
            if (password_verify($data['password'], $resultat['mdp'])) {
                return $resultat;
            }
        }
    }
}
