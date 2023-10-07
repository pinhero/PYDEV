<?php

namespace App\Contracts\Expertise;

interface TypeExpertiseContract
{

    public function listTypeExpertises(string $order = 'id', string $sort = 'desc', array $columns = ['*']);


    public function findTypeExpertiseById(int $id);


    public function createTypeExpertise(array $params);


    public function updateTypeExpertise(array $slug, array $params);


    public function deleteTypeExpertise($id);


    public function findTypeExpertiseBySlug(array $slug);

}
