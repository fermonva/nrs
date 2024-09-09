<?php

namespace App\Dtos;

readonly class ClientListDto
{
    public function __construct(
        public int $client_id,
        public string $full_name,
        public string $company_name,
        public string $gas_quality_name,
        public float $gas_quality_price,
        public float $sale_price,
        public float $profit,
    ) {
    }
}
