<?php

namespace App\Repositories;

use App\Models\GasQuality;

class GasQualityRepository implements GasQualityRepositoryInterface
{
    public function getAllGasQualities()
    {
        return GasQuality::all();
    }

    public function getGasQualityById($id)
    {
        return GasQuality::find($id);
    }

    public function createGasQuality(array $data): GasQuality
    {
        return GasQuality::create($data);
    }

    public function updateGasQuality(GasQuality $gasQuality, array $data): bool
    {
        return $gasQuality->update($data);
    }

    public function deleteGasQuality(GasQuality $gasQuality): bool
    {
        return $gasQuality->delete();
    }
}
