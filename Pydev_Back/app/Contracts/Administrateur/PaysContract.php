<?php

namespace App\Contracts\Administrateur;

interface PaysContract
{
   
    public function listPays(string $order = 'country_name', string $sort = 'asc', array $columns = ['*']);

   
    public function findPaysById(int $id);

    
    public function createPays(array $params);

    
    public function updatePays(array $slug,array $params);

    
    public function deletePays($id);

    
    public function findPaysBySlug(array $slug);

}
