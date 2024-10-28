<?php

namespace App\Dtos;

readonly class ClientDto
{
    public function __construct(
        public int $client_id = 0,
        public string $first_name = '',
        public string $last_name = '',
        public string $dni = '',
        public int $gas_quality_id = 0,
        public int $provider_id = 0,
        public float $price = 0.0,
        public float $sale_price = 0.0,
    ) {
    }
}
