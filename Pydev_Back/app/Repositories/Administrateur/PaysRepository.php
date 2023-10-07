<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\PaysContract;
use App\Models\Administrateur\Pays;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class PaysRepository extends BaseRepository implements PaysContract
{
   
    public function __construct(Pays $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listPays(string $order = 'country_name', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findPaysById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findPaysBySlug(array $slug)
    {
        try {
            return $this->model::with('departements')->where($slug)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createPays(array $params)
    {
        try {
            $collection = collect($params);

            $pays = new Pays($collection->all());

            $pays->save();

            return $pays;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updatePays($slug,array $params)
    {
        $pays = isset($params['id'])? $this->findPaysById($params['id']): $this->findPaysBySlug($slug);

        $collection = collect($params);

        $pays->update($collection->all());

        return $pays;
    }

    
    public function deletePays($id)
    {
        $pays = $this->findPaysById($id);

        $pays->delete();

        return $pays;
    }

    
}
