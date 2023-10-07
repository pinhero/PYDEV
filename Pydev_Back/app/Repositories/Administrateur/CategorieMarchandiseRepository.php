<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\CategorieMarchandiseContract;
use App\Models\Administrateur\CategorieMarchandise;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class CategorieMarchandiseRepository extends BaseRepository implements CategorieMarchandiseContract
{
   
    public function __construct(CategorieMarchandise $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listCategorieMarchandise(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findCategorieMarchandiseById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findCategorieMarchandiseBySlug(array $slug)
    {
        try {
            return $this->model::with('marchandises')->where($slug)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createCategorieMarchandise(array $params)
    {
        try {
            $collection = collect($params);

            $categorieMarchandise = new CategorieMarchandise($collection->all());

            $categorieMarchandise->save();

            return $categorieMarchandise;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateCategorieMarchandise($slug,array $params)
    {
        $categorieMarchandise = isset($params['id'])? $this->findCategorieMarchandiseById($params['id']): $this->findCategorieMarchandiseBySlug($slug);

        $collection = collect($params);

        $categorieMarchandise->update($collection->all());

        return $categorieMarchandise;
    }

    
    public function deleteCategorieMarchandise($id)
    {
        $categorieMarchandise = $this->findCategorieMarchandiseById($id);

        $categorieMarchandise->delete();

        return $categorieMarchandise;
    }

    
}
