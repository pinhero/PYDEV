<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\MarchandiseContract;
use App\Models\Administrateur\Marchandise;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class MarchandiseRepository extends BaseRepository implements MarchandiseContract
{
   
    public function __construct(Marchandise $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listMarchandise(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findMarchandiseById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findMarchandiseBySlug(array $slug)
    {
        try {
            return $this->findOneBy($slug);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createMarchandise(array $params)
    {
        try {
            $collection = collect($params);

            $marchandise = new Marchandise($collection->all());

            $marchandise->save();

            return $marchandise;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateMarchandise($slug,array $params)
    {
        $marchandise = isset($params['id'])? $this->findMarchandiseById($params['id']): $this->findMarchandiseBySlug($slug);

        $collection = collect($params);

        $marchandise->update($collection->all());

        return $marchandise;
    }

    
    public function deleteMarchandise($id)
    {
        $marchandise = $this->findMarchandiseById($id);

        $marchandise->delete();

        return $marchandise;
    }

    
}
