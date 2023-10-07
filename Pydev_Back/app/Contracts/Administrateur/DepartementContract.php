<?php

namespace App\Contracts\Administrateur;

interface DepartementContract
{
   
    public function listDepartement(string $order = 'name', string $sort = 'asc', array $columns = ['*']);

    public function findDepartementById(int $id);

    
    public function createDepartement(array $params);

    
    public function updateDepartement(array $slug,array $params);

    
    public function deleteDepartement($id);

    
    public function findDepartementBySlug(array $slug);

}
