<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Phone extends Model
{
    use HasUuids, HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'phone',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_phone', 'phone_id', 'company_id');
    }
}
