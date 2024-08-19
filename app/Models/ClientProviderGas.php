<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProviderGas extends Model
{
    use HasFactory;

    protected $table = 'client_provider_gas';

    protected $fillable = [
        'client_id',
        'provider_id',
        'gas_quality_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function gasQuality()
    {
        return $this->belongsTo(GasQuality::class, 'gas_quality_id');
    }
}
