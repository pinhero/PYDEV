<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\UniteMesureContract;
use App\Models\Administrateur\UniteMesure;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class UniteMesureRepository extends BaseRepository implements UniteMesureContract
{
   
    public function __construct(UniteMesure $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listUniteMesure(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findUniteMesureById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findUniteMesureBySlug(array $slug)
    {
        try {
            return $this->findOneBy($slug);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createUniteMesure(array $params)
    {
        try {
            $collection = collect($params);

            $devise = new UniteMesure($collection->all());

            $devise->save();

            return $devise;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateUniteMesure($slug,array $params)
    {
        $devise = isset($params['id'])? $this->findUniteMesureById($params['id']): $this->findUniteMesureBySlug($slug);

        $collection = collect($params);

        $devise->update($collection->all());

        return $devise;
    }

    
    public function deleteUniteMesure($id)
    {
        $devise = $this->findUniteMesureById($id);

        $devise->delete();

        return $devise;
    }

    
}
