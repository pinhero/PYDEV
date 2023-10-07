<?php

namespace App\Contracts\Administrateur;

interface TypeDocumentationContract
{
   
    public function listTypeDocumentation(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findTypeDocumentationById(int $id);

    
    public function createTypeDocumentation(array $params);

    
    public function updateTypeDocumentation(array $slug,array $params);

    
    public function deleteTypeDocumentation($id);

    
    public function findTypeDocumentationBySlug(array $slug);

}
