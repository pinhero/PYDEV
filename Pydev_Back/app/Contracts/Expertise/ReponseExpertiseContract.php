<?php

namespace App\Contracts\Expertise;

interface ReponseExpertiseContract
{
   
    public function getAllReponseExpertises();

   
    public function findReponseExpertiseById(int $id);

    
    public function createReponseExpertise(array $params);

    
    public function getAllReponseExpertisesByExpertise(int $id);

}
