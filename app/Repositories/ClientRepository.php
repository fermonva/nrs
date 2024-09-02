<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientProviderGas;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients()
    {
        return Client::select(
            'clients.id',
            'clients.first_name',
            'clients.last_name',
            'clients.dni',
            'gas_qualities.id as gas_quality_id',
            'gas_qualities.name as gas_quality_name',
            'providers.id as provider_id',
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

    public function getClientById($id)
    {
        return Client::select(
            'clients.id',
            'clients.first_name',
            'clients.last_name',
            'clients.dni',
            'gas_qualities.id as gas_quality_id',
            'gas_qualities.name as gas_quality_name',
            'providers.id as provider_id',
            'providers.company_name as provider_name',
            'gas_qualities.price as purchase_price',
            DB::raw('gas_qualities.price * 1.2 as sale_price'),
            DB::raw('gas_qualities.price * 0.2 as profit')
        )
        ->join('client_provider_gas', 'client_provider_gas.client_id', '=', 'clients.id')
        ->join('providers', 'client_provider_gas.provider_id', '=', 'providers.id')
        ->join('gas_qualities', 'client_provider_gas.gas_quality_id', '=', 'gas_qualities.id')
        ->where('clients.id', $id)
        ->first();
    }

    public function createClient(array $data): Client
    {
        DB::beginTransaction();
        try {
            $client = Client::create($data);

            if (isset($data['provider_id']) && isset($data['gas_quality_id'])) {
                ClientProviderGas::create([
                    'client_id'      => $client->id,
                    'provider_id'    => $data['provider_id'],
                    'gas_quality_id' => $data['gas_quality_id'],
                ]);
            }

            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateClient(Client $client, array $data): bool
    {
        DB::beginTransaction();
        try {
            $result = $client->update($data);

            if (isset($data['provider_id']) && isset($data['gas_quality_id'])) {
                $clientProviderGas = $client->clientProviderGas()->first();

                if ($clientProviderGas) {
                    $clientProviderGas->update([
                        'provider_id'    => $data['provider_id'],
                        'gas_quality_id' => $data['gas_quality_id'],
                    ]);
                }
            }

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteClient(Client $client): bool
    {
        return $client->delete();
    }

    public function getClientsWithNegativeProfit()
    {
        return Client::select(
            'clients.first_name',
            'clients.last_name',
            'client_provider_gas.gas_quality_id',
            'gas_qualities.price as purchase_price',
            DB::raw('gas_qualities.price * 1.2 as sale_price'),
            DB::raw('gas_qualities.price * 0.2 as profit')
        )
            ->join('client_provider_gas', 'client_provider_gas.client_id', '=', 'clients.id')
            ->join('gas_qualities', 'client_provider_gas.gas_quality_id', '=', 'gas_qualities.id')
            ->havingRaw('profit < 0')
            ->get();
    }
}
