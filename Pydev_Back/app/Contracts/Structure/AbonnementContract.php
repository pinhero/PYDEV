<?php

namespace App\Contracts\Client;

interface AbonnementContract
{

    public function listAbonnements(string $order = 'id', string $sort = 'desc', array $columns = ['*']);


    public function findAbonnementById(int $id);
    
    public function findAbonnementByLibelle(string $libelle);


    public function createAbonnement(array $params);


    public function updateAbonnement(array $slug, array $params);


    public function deleteAbonnement($id);

}
