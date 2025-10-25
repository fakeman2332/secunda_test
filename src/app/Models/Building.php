<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasUuids, HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'building_id');
    }
}
