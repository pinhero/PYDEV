<?php

namespace App\Contracts\Administrateur;

interface DocumentTypeContract
{
   
    public function listDocumentType(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findDocumentTypeById(int $id);

    
    public function createDocumentType(array $params);

    
    public function updateDocumentType(array $slug,array $params);

    
    public function deleteDocumentType($id);

    
    public function findDocumentTypeBySlug(array $slug);

}
