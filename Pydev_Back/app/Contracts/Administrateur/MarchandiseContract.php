<?php

namespace App\Contracts\Administrateur;

interface MarchandiseContract
{
   
    public function listMarchandise(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findMarchandiseById(int $id);

    
    public function createMarchandise(array $params);

    
    public function updateMarchandise(array $slug,array $params);

    
    public function deleteMarchandise($id);

    
    public function findMarchandiseBySlug(array $slug);

}
