<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'country',
        'cif',
        'registration_date',
    ];

    public function clientProviderGas(): HasMany
    {
        return $this->hasMany(ClientProviderGas::class, 'provider_id');
    }
}
