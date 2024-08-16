<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'registration_date',
    ];

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'client_provider')
        ->withPivot('gas_quality_id', 'purchase_price', 'sale_price');
    }
}
