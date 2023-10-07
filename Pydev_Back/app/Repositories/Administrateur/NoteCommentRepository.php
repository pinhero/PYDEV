<?php

namespace App\Repositories\Administrateur;

use App\Contracts\Administrateur\NoteCommentContract;
use App\Models\Administrateur\NoteComment;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class NoteCommentRepository extends BaseRepository implements NoteCommentContract
{
   
    public function __construct(NoteComment $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
  
    public function listNoteComment(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }
   
    public function findNoteCommentById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findNoteCommentBySlug(array $slug)
    {
        try {
            return $this->findOneBy($slug);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createNoteComment(array $params)
    {
        try {
            $collection = collect($params);

            $devise = new NoteComment($collection->all());

            $devise->save();

            return $devise;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
  
    public function updateNoteComment(array $params)
    {
        $devise = $this->findNoteCommentById($params['id']);

        $collection = collect($params);

        $devise->update($collection->all());

        return $devise;
    }

    
    public function deleteNoteComment($id)
    {
        $devise = $this->findNoteCommentById($id);

        $devise->delete();

        return $devise;
    }

    
}
