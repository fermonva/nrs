<?php

namespace App\Repositories;

use App\Models\Provider;

interface ProviderRepositoryInterface
{
    public function getAllProviders();

    public function getProviderById($id);

    public function createProvider(array $data): Provider;

    public function updateProvider(Provider $provider, array $data): bool;

    public function deleteProvider(Provider $provider): bool;
}
