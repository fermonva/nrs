<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'registration_date',
    ];

    public function clientProviderGas(): HasOne
    {
        return $this->hasOne(ClientProviderGas::class, 'client_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getSalePriceAttribute(): float
    {
        return $this->clientProviderGas?->gasQuality?->price * 1.2 ?? 0.0;
    }

    public function getProfitAttribute(): float
    {
        return $this->clientProviderGas?->gasQuality?->price * 0.2 ?? 0.0;
    }
}
