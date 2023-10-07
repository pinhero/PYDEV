<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\DeviseContract;
use App\Models\Administrateur\Devise;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class DeviseRepository extends BaseRepository implements DeviseContract
{
   
    public function __construct(Devise $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listDevises(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findDeviseById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findDeviseBySlug(array $slug)
    {
        try {
            return $this->findOneBy($slug);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createDevise(array $params)
    {
        try {
            $collection = collect($params);

            $devise = new Devise($collection->all());

            $devise->save();

            return $devise;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateDevise($slug,array $params)
    {
        $devise = isset($params['id'])? $this->findDeviseById($params['id']): $this->findDeviseBySlug($slug);

        $collection = collect($params);

        $devise->update($collection->all());

        return $devise;
    }

    
    public function deleteDevise($id)
    {
        $devise = $this->findDeviseById($id);

        $devise->delete();

        return $devise;
    }

    
}
