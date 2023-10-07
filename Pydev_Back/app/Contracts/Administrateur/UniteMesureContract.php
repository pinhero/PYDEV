<?php

namespace App\Contracts\Administrateur;

interface UniteMesureContract
{
   
    public function listUniteMesure(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findUniteMesureById(int $id);

    
    public function createUniteMesure(array $params);

    
    public function updateUniteMesure(array $slug,array $params);

    
    public function deleteUniteMesure($id);

    
    public function findUniteMesureBySlug(array $slug);

}
