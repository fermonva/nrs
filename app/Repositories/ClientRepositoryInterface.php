<?php

namespace App\Repositories;

use App\Dtos\ClientDto;
use App\Models\Client;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function getAllClients(): Collection;

    public function getClientById($id): ClientDto;

    public function createClient(array $data): ClientDto;

    public function updateClient(Client $client, array $data): bool;

    public function deleteClient(Client $client): bool;

    public function getClientsWithNegativeProfit();
}
