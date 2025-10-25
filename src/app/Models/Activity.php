<?php

namespace App\Models;

use App\Models\Activity as ModelsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Activity extends Model
{
    use HasUuids, HasFactory, HasRecursiveRelationships;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'activity_id',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function getParentKeyName(): string
    {
        return 'parent_id';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ModelsActivity::class, 'parent_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_activity', 'activity_id', 'company_id');
    }

    public function children(): Activity|HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }
}
