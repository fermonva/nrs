<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::select(
            'clients.id',
            'clients.first_name',
            'clients.last_name',
            'clients.dni',
            'gas_qualities.name as gas_quality_name',
            'providers.company_name as provider_name',
            'gas_qualities.price as purchase_price',
            DB::raw('gas_qualities.price * 1.2 as sale_price'),
            DB::raw('gas_qualities.price * 0.2 as profit')
        )
        ->join('client_provider_gas', 'client_provider_gas.client_id', '=', 'clients.id')
        ->join('providers', 'client_provider_gas.provider_id', '=', 'providers.id')
        ->join('gas_qualities', 'client_provider_gas.gas_quality_id', '=', 'gas_qualities.id')
        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellido',
            'DNI',
            'Calidad del gas',
            'Proveedor',
            'Precio de compra',
            'Precio de venta',
            'Beneficio',
        ];
    }
}
