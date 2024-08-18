<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasQuality extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function clientProviderGas()
    {
        return $this->hasMany(ClientProviderGas::class, 'gas_quality_id');
    }
}
