<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'country',
        'cif',
        'registration_date',
    ];

    public function clientProviderGas()
    {
        return $this->hasMany(ClientProviderGas::class, 'provider_id');
    }
}
