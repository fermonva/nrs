<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasQuality extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'provider_id'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
