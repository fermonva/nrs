<?php

namespace App\Repositories;

use App\Models\Provider;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function getAllProviders()
    {
        return Provider::all();
    }

}
