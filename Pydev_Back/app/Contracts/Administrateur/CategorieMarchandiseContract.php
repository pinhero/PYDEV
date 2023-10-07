<?php

namespace App\Contracts\Administrateur;

interface CategorieMarchandiseContract
{
   
    public function listCategorieMarchandise(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findCategorieMarchandiseById(int $id);

    
    public function createCategorieMarchandise(array $params);

    
    public function updateCategorieMarchandise(array $slug,array $params);

    
    public function deleteCategorieMarchandise($id);

    
    public function findCategorieMarchandiseBySlug(array $slug);

}
