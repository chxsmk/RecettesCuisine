<?php
require_once("Recette.php");

interface RecetteStorage
{
    public function read($id);
    public function readAll();
    public function create(Recette $recette);
    public function deleteRecette($id);
    public function update(Recette $recette, $id);
    public function readAllUsers();
    public function deleteUsername($user);
}
