<?php
namespace App\Repositories\Client;

use App\Contracts\Client\ClientContract;
use App\Models\Client\Client as SrtuctureClient;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class ClientRepository extends BaseRepository implements ClientContract
{
    public function __construct(SrtuctureClient $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->clientRelationship = ['abonnements', 'user', 'cevs'];
    }

    public function getAllClients(string $order = 'user_id', string $sort = 'desc', array $columns = ['*'])
    {
        try {
            $clients = $this->model::with($this->clientRelationship)->get();
            return $clients;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function findClientById(int $id)
    {
        try {
            return $this->model::with($this->clientRelationship)->whereUserId($id)->first();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }


    public function getAllClientsByAbonnements(int $id)
    {
        try {
            $clients = $this->model::with($this->clientRelationship)->whereDomaineClient($id)->get();
            return $clients;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
