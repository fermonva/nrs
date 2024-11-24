<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProviderGas extends Model
{
    use HasFactory;

    protected $table = 'client_provider_gas';

    protected $fillable = [
        'client_id',
        'provider_id',
        'gas_quality_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function gasQuality(): BelongsTo
    {
        return $this->belongsTo(GasQuality::class);
    }
}
