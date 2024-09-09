<?php

namespace App\Dtos;

readonly class ClientDto
{
    public function __construct(
        public int $client_id,
        public string $first_name,
        public string $last_name,
        public string $dni,
        public int $gas_quality_id,
        public int $provider_id,
        public float $price,
        public float $sale_price,
    ) {
    }
}
