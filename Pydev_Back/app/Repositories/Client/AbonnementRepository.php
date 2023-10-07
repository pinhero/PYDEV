<?php

namespace App\Repositories\Client;

use Kkiapay\Kkiapay;
use App\Models\Client\Abonnement;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use App\Contracts\Client\AbonnementContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class AbonnementRepository extends BaseRepository implements AbonnementContract
{

    public function __construct(Abonnement $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listAbonnements(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function findAbonnementById(int $id)
    {
        try {
            return  $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function findAbonnementByLibelle(string $libelle)
    {
        try {
            return  $this->model::whereLibelle($libelle);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function createAbonnement(array $params)
    {
        try {
            $collection = collect($params);

            $abonnement = new Abonnement($collection->all());

            $abonnement->save();

            return $abonnement;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function updateAbonnement($id, array $params)
    {
        $typeClient =  $this->findAbonnementById($id);

        $collection = collect($params);

        $typeClient->update($collection->all());

        return $typeClient;
    }


    public function deleteAbonnement($id)
    {
        $typeClient = $this->findAbonnementById($id);

        $typeClient->delete();

        return $typeClient;
    }

    public function checkAbonnement($id)
    {
        $public_key ="";
        $private_key = "";
        $secret = "";

        $kkiapay = new Kkiapay(
            $public_key,
            $private_key,
            $secret,
            $sandbox = true
        );
        return $kkiapay->verifyTransaction($id);;
    }
}
