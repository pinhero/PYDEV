<?php

namespace App\Contracts\Administrateur;

interface DeviseContract
{
   
    public function listDevises(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findDeviseById(int $id);

    
    public function createDevise(array $params);

    
    public function updateDevise(array $slug,array $params);

    
    public function deleteDevise($id);

    
    public function findDeviseBySlug(array $slug);

}
