<?php

namespace App\Contracts\Administrateur;

interface TypeCamionContract
{
   
    public function listTypeCamion(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findTypeCamionById(int $id);

    
    public function createTypeCamion(array $params);

    
    public function updateTypeCamion(array $slug,array $params);

    
    public function deleteTypeCamion($id);

    
    public function findTypeCamionBySlug(array $slug);

}
