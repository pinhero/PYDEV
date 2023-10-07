<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\VilleContract;
use App\Models\Administrateur\Ville;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class VilleRepository extends BaseRepository implements VilleContract
{
   
    public $villeRelationship;
    public function __construct(Ville $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->villeRelationship = ['departement'];
    }
  
    public function listVille(string $order = 'name', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findVilleById(int $id)
    {
        try {
            return $this->model::with($this->villeRelationship)->whereId($id)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findVilleBySlug(array $slug)
    {
        try {
            return $this->model::with($this->villeRelationship)->whereSlug($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createVille(array $params)
    {
        try {
            $collection = collect($params);

            $ville = new Ville($collection->all());

            $ville->save();

            return $ville;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateVille($slug,array $params)
    {
        $ville = isset($params['id'])? $this->findVilleById($params['id']): $this->findVilleBySlug($slug);

        $collection = collect($params);

        $ville->update($collection->all());

        return $ville;
    }

    
    public function deleteVille($id)
    {
        $ville = $this->findVilleById($id);

        $ville->delete();

        return $ville;
    }

    
}
