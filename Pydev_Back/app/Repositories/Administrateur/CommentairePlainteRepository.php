<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\CommentairePlainteContract;
use App\Models\Administrateur\CommentairePlainte;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Auth;


class CommentairePlainteRepository extends BaseRepository implements CommentairePlainteContract
{
   
    public function __construct(CommentairePlainte $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->commentairePlainteRelationship = ['plainte' ];
    }
  
    public function getAllCommentairePlaintes(string $order = 'id', string $sort = 'desc', array $columns = ['*']){
        try {
            $commentairePlaintes = $this->model::with($this->commentairePlainteRelationship)->get();
            return $commentairePlaintes;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function findCommentairePlainteById(int $id)
    {
        try {
            return $this->model::whereId($id)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    
    public function createCommentairePlainte(array $params)
    {
        try {
            $collection = collect($params);

            $commentairePlainte = new CommentairePlainte($collection->all());

            $commentairePlainte->save();

            return $commentairePlainte;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function getAllCommentairePlaintesByPlainte(int $id){
        try {
            $commentairePlaintes = $this->model::with($this->commentairePlainteRelationship)->wherePlainteId($id)->get();

            return $commentairePlaintes;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    
}
