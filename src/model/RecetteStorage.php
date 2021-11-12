<?php
require_once("Recette.php");

interface RecetteStorage
{
    public function read($id);
    public function readAll();
    public function create(Recette $recette);
    public function delete($id);
    public function update(Recette $recette, $id);
    public function readAllUsers();
    //public function readUser($user);
    public function deleteUsername($user);
}
