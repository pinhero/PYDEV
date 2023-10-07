<?php

namespace App\Contracts\Expertise;

interface AppreciationContract
{
   
    public function getAllAppreciations();

   
    public function findAppreciationById(int $id);

    
    public function createAppreciation(array $params);


    public function getAllAppreciationsByExpertise(int $id);

    public function getAllAppreciationsByExpert(int $id);

}
