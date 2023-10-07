<?php

namespace App\Contracts\Administrateur;

interface DocumentationContract
{
   
    public function listDocumentation(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findDocumentationById(int $id);

    
    public function createDocumentation(array $params);

    public function findDocumentationBySlug(array $slug);

    
    public function updateDocumentation(array $slug,array $params);

    
    public function deleteDocumentation($id);

}
