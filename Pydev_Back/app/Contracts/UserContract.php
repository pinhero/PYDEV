<?php

namespace App\Contracts;

interface UserContract
{
   
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    public function findUserById(int $id);

    public function findUserByRole(string $role);

    public function findUserByStatus(string $status);

    public function getListeUserWithoutAdmin(string $order = 'lastname', string $sort = 'asc', array $columns = ['*']);
}
