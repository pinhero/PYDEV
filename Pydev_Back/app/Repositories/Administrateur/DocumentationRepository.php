<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\DocumentationContract;
use App\Models\Administrateur\Documentation;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class DocumentationRepository extends BaseRepository implements DocumentationContract
{
   
    public $documentationRelationship;
    public function __construct(Documentation $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->documentationRelationship = ['type_documentation'];
    }
  
    public function listDocumentation(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model::with($this->documentationRelationship)->get();
    }
   
    public function findDocumentationById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }
    public function findDocumentationBySlug(array $slug)
    {
        try {
            return $this->model::with($this->documentationRelationship)->where($slug)->first();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    public function createDocumentation(array $params)
    {
        try {
            $collection = collect($params);

            $documentation = new Documentation($collection->all());

            $documentation->save();

            return $documentation;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateDocumentation($slug,array $params)
    {
        $documentation = isset($params['id'])? $this->findDocumentationById($params['id']): $this->findDocumentationBySlug($slug);

        $collection = collect($params);

        $documentation->update($collection->all());

        return $documentation;
    }

    
    public function deleteDocumentation($id)
    {
        $documentation = $this->model::whereId($id)->firstOrFail();
        $documentation->delete();
        return $documentation;
    }

    
}
