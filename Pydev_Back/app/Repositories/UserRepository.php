<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User as ModelsUser;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository extends BaseRepository implements UserContract
{
    public $userRelationship;


    public function __construct(ModelsUser $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    public function listUsers(string $order = 'lastname', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function findUserById(int $id)
    {
        try {
            return $this->model::whereId($id)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    public function findUserByStatus(string $status)
    {
        try {
            return $this->model::whereStatus($status)->get();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }
    public function findUserByRole(string $role)
    {
        try {
            return $this->findOneBy(['role'=>$role]);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }
    public function getListeUserWithoutAdmin(string $order = 'email', string $sort = 'asc', array $columns = ['*']){
        try {
            return $this->model::whereIn('role', [ 'ROLE_CLIENT'])->get($columns, $order, $sort);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }


}
