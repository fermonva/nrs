<?php

namespace App\Repositories;

use App\Models\GasQuality;

interface GasQualityRepositoryInterface
{
    public function getAllGasQualities();

    public function getGasQualityById($id);

    public function createGasQuality(array $data): GasQuality;

    public function updateGasQuality(GasQuality $gasQuality, array $data): bool;

    public function deleteGasQuality(GasQuality $gasQuality): bool;
}
