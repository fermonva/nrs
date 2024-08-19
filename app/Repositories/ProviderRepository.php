<?php

namespace App\Repositories;

use App\Models\Provider;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $provider = Provider::create($data);

            DB::commit();
            return $provider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProvider(Provider $provider, array $data): bool
    {
        DB::beginTransaction();
        try {
            $result = $provider->update($data);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProvider(Provider $provider): bool
    {
        return $provider->delete();
    }
}
