<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\TypeDocumentationContract;
use App\Models\Administrateur\TypeDocumentation;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class TypeDocumentationRepository extends BaseRepository implements TypeDocumentationContract
{
   
    public function __construct(TypeDocumentation $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listTypeDocumentation(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findTypeDocumentationById(int $id)
    {
        try {
            return  $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findTypeDocumentationBySlug(array $slug)
    {
        try {
            return $this->model::with('documentations')->where($slug)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createTypeDocumentation(array $params)
    {
        try {
            $collection = collect($params);

            $typeDocumentation = new TypeDocumentation($collection->all());

            $typeDocumentation->save();

            return $typeDocumentation;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateTypeDocumentation($slug,array $params)
    {
        $typeDocumentation = isset($params['id'])? $this->findTypeDocumentationById($params['id']): $this->findTypeDocumentationBySlug($slug);

        $collection = collect($params);

        $typeDocumentation->update($collection->all());

        return $typeDocumentation;
    }

    
    public function deleteTypeDocumentation($id)
    {
        $typeDocumentation = $this->findTypeDocumentationById($id);

        $typeDocumentation->delete();

        return $typeDocumentation;
    }

    
}
