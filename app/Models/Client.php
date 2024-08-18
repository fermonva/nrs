<?php

namespace App\Models;

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
}
