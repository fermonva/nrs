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

    public function gasQualities()
    {
        return $this->hasMany(GasQuality::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_provider')
        ->withPivot('gas_quality_id', 'purchase_price', 'sale_price')
        ->withTimestamps();
    }
}
