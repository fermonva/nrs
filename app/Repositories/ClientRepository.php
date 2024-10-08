<?php

namespace App\Repositories;

use App\Dtos\ClientDto;
use App\Dtos\ClientListDto;
use App\Exceptions\ClientCreationException;
use App\Models\Client;
use App\Models\ClientProviderGas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function getAllClients(): Collection
    {
        $clientProviderGas = $this->model->with([
            'clientProviderGas.provider:id,company_name',
            'clientProviderGas.gasQuality:id,name,price'
        ])->select('id', 'first_name', 'last_name')->get();

        return $clientProviderGas->map(function ($client) {
            $provider   = $client->clientProviderGas->provider;
            $gasQuality = $client->clientProviderGas->gasQuality;

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
    }

    public function getClientById($id): ClientDto
    {
        $client = $this->model->with([
            'clientProviderGas.provider:id',
            'clientProviderGas.gasQuality:id,price'
        ])->select('id', 'first_name', 'last_name', 'dni')->findOrFail($id);

        return new ClientDto(
            client_id: $client->id                                     ?? 0,
            first_name: $client->first_name                            ?? 'N/A',
            last_name: $client->last_name                              ?? 'N/A',
            dni: $client->dni                                          ?? 'N/A',
            gas_quality_id: $client->clientProviderGas->gasQuality->id ?? 0,
            provider_id: $client->clientProviderGas->provider->id      ?? 0,
            price: $client->clientProviderGas->gasQuality->price       ?? 0.0,
            sale_price: $client->sale_price                            ?? 0.0
        );
    }

    public function createClient(array $data): ClientDto
    {
        DB::beginTransaction();
        try {
            $client = $this->model->create($data);

            if (isset($data['provider_id']) && isset($data['gas_quality_id'])) {
                ClientProviderGas::create([
                    'client_id'      => $client->id,
                    'provider_id'    => $data['provider_id'],
                    'gas_quality_id' => $data['gas_quality_id'],
                ]);
            }

            DB::commit();
            return new ClientDto(
                client_id: $client->id,
                first_name: $client->first_name,
                last_name: $client->last_name,
                dni: $client->dni
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
