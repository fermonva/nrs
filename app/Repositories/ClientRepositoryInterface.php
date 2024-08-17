<?php

namespace App\Repositories;

use App\Models\Client;

interface ClientRepositoryInterface
{
    public function getAllClients();

    public function getClientById($id);

    public function createClient(array $data): Client;

    public function updateClient(Client $client, array $data): bool;

    public function deleteClient(Client $client): bool;

    public function getClientsWithNegativeProfit();
}
