<?php

namespace App\Repositories;

use App\Models\Provider;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getAllProviders()
    {
        return Provider::all();
    }

    public function getProviderById($id)
    {
        return Provider::find($id);
    }

    public function createProvider(array $data): Provider
    {
        return Provider::create($data);
    }

    public function updateProvider(Provider $provider, array $data): bool
    {
        return $provider->update($data);
    }

    public function deleteProvider(Provider $provider): bool
    {
        return $provider->delete();
    }

}
