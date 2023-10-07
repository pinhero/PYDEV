<?php

namespace App\Contracts\Administrateur;

interface NoteCommentContract
{
   
    public function listNoteComment(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

   
    public function findNoteCommentById(int $id);

    
    public function createNoteComment(array $params);

    
    public function updateNoteComment(array $params);

    
    public function deleteNoteComment($id);

    
}
