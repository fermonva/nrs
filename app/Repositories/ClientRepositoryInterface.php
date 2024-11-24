<?php

namespace App\Repositories;

use App\Dtos\ClientDto;
use App\Dtos\ClientListDto;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function getAllClients($perPage): LengthAwarePaginator;

    public function getClientById($id): ClientDto;

    public function createClient(array $data): ClientDto;

    public function updateClient(Client $client, array $data): bool;

    public function deleteClient(Client $client): bool;

    public function getClientsWithNegativeProfit();
}
