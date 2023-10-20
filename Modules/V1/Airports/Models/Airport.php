<?php

namespace Modules\V1\Airports\Models;

use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Modules\V1\Airports\Observers\AirportObserver;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property integer $airport_id
 * @property float $latitude
 * @property float $longitude
 * @property integer $iata_code
 */
class Airport extends Model
{
    use HasFactory;
    use Uuids;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'airport_id',
        'latitude',
        'longitude',
        'iata_code',
    ];

    protected static function boot(): void
    {
        parent::boot();
        self::observe(AirportObserver::class);
    }

    /**
     * @return HasMany<AirportDetail>
     */
    public function airportDetails(): HasMany
    {
        return $this->hasMany(AirportDetail::class, 'airport_id', 'id');
    }
}
