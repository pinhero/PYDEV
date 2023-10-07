<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\DepartementContract;
use App\Models\Administrateur\Departement;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class DepartementRepository extends BaseRepository implements DepartementContract
{
    public $departementRelationship;
   
    public function __construct(Departement $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->departementRelationship = ['villes','country'];
    }
  
    public function listDepartement(string $order = 'name', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findDepartementById(int $id)
    {
        try {
            return $this->model::with($this->departementRelationship)->whereId($id)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findDepartementBySlug(array $slug)
    {
        try {
            return $this->model::with($this->departementRelationship)->where($slug)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createDepartement(array $params)
    {
        try {
            $collection = collect($params);

            $departement = new Departement($collection->all());

            $departement->save();

            return $departement;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateDepartement($slug,array $params)
    {
        $departement = isset($params['id'])? $this->findDepartementById($params['id']): $this->findDepartementBySlug($slug);

        $collection = collect($params);

        $departement->update($collection->all());

        return $departement;
    }

    
    public function deleteDepartement($id)
    {
        $departement = $this->findDepartementById($id);

        $departement->delete();

        return $departement;
    }

    
}
