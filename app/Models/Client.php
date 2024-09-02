<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'registration_date',
    ];

    public function clientProviderGas()
    {
        return $this->hasOne(ClientProviderGas::class, 'client_id');
    }

    public function scopeGetAllClients(Builder $builder): Builder
    {
        return $builder
            ->select('clients.id', 'clients.first_name', 'clients.last_name', 'clients.dni', 'clients.registration_date')
            ->join('gas_qualities', 'clients.gas_quality_id', '=', 'gas_qualities.id')
            ->join('providers', 'clients.provider_id', '=', 'providers.id')
            ->addSelect([
                DB::raw('gas_qualities.id as gas_quality_id'),
                DB::raw('gas_qualities.name as gas_quality_name'),
                DB::raw('gas_qualities.price as purchase_price'),
                DB::raw('providers.id as provider_id'),
                DB::raw('providers.company_name as provider_name'),
                DB::raw('gas_qualities.price * 1.2 as sale_price'),
                DB::raw('gas_qualities.price * 0.2 as profit')
            ])->get();
    }
}
