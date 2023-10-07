<?php

namespace App\Contracts\Administrateur;

interface CategorieCamionContract
{
   
    public function listCategorieCamion(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findCategorieCamionById(int $id);

    
    public function createCategorieCamion(array $params);

    
    public function updateCategorieCamion(array $slug,array $params);

    
    public function deleteCategorieCamion($id);

    
    public function findCategorieCamionBySlug(array $slug);

}
