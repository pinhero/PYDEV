<?php

namespace App\Contracts\Expertise;

interface CategorieExpertiseContract
{

    public function listCategorieExpertises(string $order = 'id', string $sort = 'desc', array $columns = ['*']);


    public function findCategorieExpertiseById(int $id);


    public function createCategorieExpertise(array $params);


    public function updateCategorieExpertise(array $slug, array $params);


    public function deleteCategorieExpertise($id);


    public function findCategorieExpertiseBySlug(array $slug);

}
