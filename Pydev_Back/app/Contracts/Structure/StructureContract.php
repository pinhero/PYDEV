<?php

namespace App\Contracts\Client;

interface ClientContract
{

    public function getAllClients();

    public function findClientById(int $id);

    public function getAllClientsByAbonnements(int $id);
}
