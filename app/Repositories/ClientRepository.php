<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients()
    {
        return Client::all();
    }

    public function getClientById($id)
    {
        return Client::findOrFail($id);
    }

    public function createClient(array $data): Client
    {
        return Client::create($data);
    }

    public function updateClient(Client $client, array $data): bool
    {
        return $client->update($data);
    }

    public function deleteClient(Client $client): bool
    {
        return $client->delete();
    }

    public function getClientsWithNegativeProfit()
    {
        return Client::whereHas('providers', function ($query) {
            $query->where('sale_price', '<', 'purchase_price');
        })->with('providers')->get();
    }
}
