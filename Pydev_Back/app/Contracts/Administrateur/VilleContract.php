<?php

namespace App\Contracts\Administrateur;

interface VilleContract
{
   
    public function listVille(string $order = 'name', string $sort = 'asc', array $columns = ['*']);

   
    public function findVilleById(int $id);

    
    public function createVille(array $params);

    
    public function updateVille(array $slug,array $params);

    
    public function deleteVille($id);

    
    public function findVilleBySlug(array $slug);

}
