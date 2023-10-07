<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\DocumentTypeContract;
use App\Models\Administrateur\DocumentType;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class DocumentTypeRepository extends BaseRepository implements DocumentTypeContract
{
   
    public function __construct(DocumentType $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listDocumentType(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findDocumentTypeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findDocumentTypeBySlug(array $slug)
    {
        try {
            return $this->findOneBy($slug);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createDocumentType(array $params)
    {
        try {
            $collection = collect($params);

            $documentType = new DocumentType($collection->all());

            $documentType->save();

            return $documentType;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateDocumentType($slug,array $params)
    {
        $documentType = isset($params['id'])? $this->findDocumentTypeById($params['id']): $this->findDocumentTypeBySlug($slug);

        $collection = collect($params);

        $documentType->update($collection->all());

        return $documentType;
    }

    
    public function deleteDocumentType($id)
    {
        $documentType = $this->findDocumentTypeById($id);

        $documentType->delete();

        return $documentType;
    }

    
}
