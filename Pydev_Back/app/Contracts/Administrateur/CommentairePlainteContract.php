<?php

namespace App\Contracts\Administrateur;

interface CommentairePlainteContract
{
   
    public function getAllCommentairePlaintes();

   
    public function findCommentairePlainteById(int $id);

    
    public function createCommentairePlainte(array $params);

    
    public function getAllCommentairePlaintesByPlainte(int $id);

}
