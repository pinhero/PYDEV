<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\CategorieCamionContract;
use App\Models\Administrateur\CategorieCamion;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class CategorieCamionRepository extends BaseRepository implements CategorieCamionContract
{
   
    public function __construct(CategorieCamion $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listCategorieCamion(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findCategorieCamionById(int $id)
    {
        try {
            return  $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findCategorieCamionBySlug(array $slug)
    {
        try {
            return $this->model::with('type_camions')->where($slug)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createCategorieCamion(array $params)
    {
        try {
            $collection = collect($params);

            $categorieCamion = new CategorieCamion($collection->all());

            $categorieCamion->save();

            return $categorieCamion;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateCategorieCamion($slug,array $params)
    {
        $categorieCamion = isset($params['id'])? $this->findCategorieCamionById($params['id']): $this->findCategorieCamionBySlug($slug);

        $collection = collect($params);

        $categorieCamion->update($collection->all());

        return $categorieCamion;
    }

    
    public function deleteCategorieCamion($id)
    {
        $categorieCamion = $this->findCategorieCamionById($id);

        $categorieCamion->delete();

        return $categorieCamion;
    }

    
}
