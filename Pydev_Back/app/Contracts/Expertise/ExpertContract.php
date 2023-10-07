<?php

namespace App\Contracts\Expertise;

interface ExpertContract
{
   
    public function getAllExperts();
   
    public function findExpertById(int $id);

    public function getAllExpertsByExpertise(int $id);

}
