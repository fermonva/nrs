<?php

namespace App\Repositories;

use App\Dtos\ClientDto;
use App\Dtos\ClientListDto;
use App\Exceptions\ClientCreationException;
use App\Models\Client;
use App\Models\ClientProviderGas;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{
    protected Client $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function getAllClients($perPage = 10): LengthAwarePaginator
    {
        $client = $this->model->with([
            'clientProviderGas.provider:id,company_name',
            'clientProviderGas.gasQuality:id,name,price'
        ])->select('id', 'first_name', 'last_name')->paginate($perPage = 10);

        $client->getCollection()->transform(function ($client) {
            $provider   = $client->clientProviderGas?->provider;
            $gasQuality = $client->clientProviderGas?->gasQuality;

            return new ClientListDto(
                client_id: $client->id                ?? 0,
                full_name: $client->full_name         ?? 'N/A',
                company_name: $provider->company_name ?? 'N/A',
                gas_quality_name: $gasQuality->name   ?? 'N/A',
                gas_quality_price: $gasQuality->price ?? 0.0,
                sale_price: $client->sale_price       ?? 0.0,
                profit: $client->profit               ?? 0.0
            );
        });

        return $client;
    }

    public function getClientById($id): ClientDto
    {
        $client = $this->model->with([
            'clientProviderGas.provider:id',
            'clientProviderGas.gasQuality:id,price'
        ])->select('id', 'first_name', 'last_name', 'dni')->findOrFail($id);

        return new ClientDto(
            client_id: $client->id,
            first_name: $client->first_name,
            last_name: $client->last_name,
            dni: $client->dni,
            gas_quality_id: $client->clientProviderGas->gasQuality->id,
            provider_id: $client->clientProviderGas->provider->id,
            price: $client->clientProviderGas->gasQuality->price,
            sale_price: $client->sale_price
        );
    }

    public function createClient(array $data): ClientDto
    {
        DB::beginTransaction();
        try {
            $client = $this->model->query()->create($data);

            if (isset($data['provider_id']) && isset($data['gas_quality_id'])) {
                ClientProviderGas::query()->create([
                    'client_id'      => $client->id,
                    'provider_id'    => $data['provider_id'],
                    'gas_quality_id' => $data['gas_quality_id'],
                ]);
            }

            $result = $this->model->with([
                'clientProviderGas.provider:id',
                'clientProviderGas.gasQuality:id,price'
            ])->select('id', 'first_name', 'last_name', 'dni')->findOrFail($client->id);

            DB::commit();

            return new ClientDto(
                client_id: $result->id,
                first_name: $result->first_name,
                last_name: $result->last_name,
                dni: $result->dni,
                gas_quality_id: $result->clientProviderGas->gasQuality->id,
                provider_id: $result->clientProviderGas->provider->id,
                price: $result->clientProviderGas->gasQuality->price,
                sale_price: $result->sale_price
            );
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ClientCreationException('Failed to create client', 500, $e);
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
            throw new \Exception($e->getMessage());
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
