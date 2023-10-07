<?php

namespace App\Contracts\Expertise;

interface ExpertiseContract
{

    public function createExpertise(array $params);
    public function createPieceExpertise(array $params);
    public function createExpertiseFile(array $params);


    public function getExpertiseByUserByStatus(string $statut);

    public function getAllExpertisesByUser();


    public function getAllExpertises($id);


    public function getAllExpertisesByStatut(string $statut);


    public function findExpertiseById(int $id);
    
    public function deleteExpertiseFile(int $id);
    
    public function deleteExpertise(int $id);

    public function changeStatusExpertise(int $id,array $params);

}
