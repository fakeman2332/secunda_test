<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasUuids, HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'building_id',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phones(): BelongsToMany
    {
        return $this->belongsToMany(Phone::class, 'company_phone', 'company_id', 'phone_id');
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'company_activity', 'company_id', 'activity_id');
    }

    /**
     * Поиск организаций в радиусе
     *
     * @param Builder $query
     * @param float $latitude - широта центральной точки
     * @param float $longitude - долгота центральной точки
     * @param int $radius - радиус в метрах
     * @return Builder
     */
    public function scopeWithinRadius(Builder $query, float $latitude, float $longitude, int $radius): Builder
    {
        $radiusInKm = $radius / 1000;

        $haversine = "(
        6371 * acos(
            cos(radians(?))
            * cos(radians(buildings.latitude))
            * cos(radians(buildings.longitude) - radians(?))
            + sin(radians(?))
            * sin(radians(buildings.latitude))
            )
        )";

        return $query
            ->join('buildings', 'companies.building_id', '=', 'buildings.id')
            ->select('companies.*')
            ->selectRaw("{$haversine} AS distance_km", [$latitude, $longitude, $latitude])
            ->whereRaw("{$haversine} <= ?", [$latitude, $longitude, $latitude, $radiusInKm])
            ->orderBy('distance_km', 'asc');
    }

    /*
    * Поиск организаций в прямоугольной области
    *
    * @param Builder $query
    * @param float $northLatitude - северная широта (верхняя граница)
    * @param float $southLatitude - южная широта (нижняя граница)
    * @param float $westLongitude - западная долгота (левая граница)
    * @param float $eastLongitude - восточная долгота (правая граница)
    * @return Builder
    */
    public function scopeWithinBoundingBox(
        Builder $query,
        float   $northLatitude,
        float   $southLatitude,
        float   $westLongitude,
        float   $eastLongitude
    ): Builder
    {
        return $query
            ->join('buildings', 'companies.building_id', '=', 'buildings.id')
            ->select('companies.*', 'buildings.latitude', 'buildings.longitude')
            ->whereBetween('buildings.latitude', [$southLatitude, $northLatitude])
            ->whereBetween('buildings.longitude', [$westLongitude, $eastLongitude])
            ->orderBy('buildings.latitude', 'desc')
            ->orderBy('buildings.longitude', 'asc');
    }
}
