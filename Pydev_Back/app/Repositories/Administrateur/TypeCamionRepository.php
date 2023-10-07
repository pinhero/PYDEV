<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\TypeCamionContract;
use App\Models\Administrateur\TypeCamion;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class TypeCamionRepository extends BaseRepository implements TypeCamionContract
{
   
    public $typeCamionRelationship;
    public function __construct(TypeCamion $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->typeCamionRelationship = ['categorie_camion'];
    }
  
    public function listTypeCamion(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model->all($columns, $order, $sort);
    }
   
    public function findTypeCamionById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findTypeCamionBySlug(array $slug)
    {
        try {
            return $this->model::with($this->typeCamionRelationship)->where($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createTypeCamion(array $params)
    {
        try {
            $collection = collect($params);

            $typeCamion = new TypeCamion($collection->all());

            $typeCamion->save();

            return $typeCamion;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateTypeCamion($slug,array $params)
    {
        $typeCamion = isset($params['id'])? $this->findTypeCamionById($params['id']): $this->findTypeCamionBySlug($slug);

        $collection = collect($params);

        $typeCamion->update($collection->all());

        return $typeCamion;
    }

    
    public function deleteTypeCamion($id)
    {
        $typeCamion = $this->findTypeCamionById($id);

        $typeCamion->delete();

        return $typeCamion;
    }

    
}
