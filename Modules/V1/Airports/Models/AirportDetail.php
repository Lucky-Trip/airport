<?php

namespace Modules\V1\Airports\Models;

use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Modules\V1\Languages\Enums\LanguageEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property string $name
 * @property string $airport_id
 * @property LanguageEnum|string $language
 * @property string $description
 * @property string $terms_and_conditions
 */
class AirportDetail extends Model
{
    use HasFactory;
    use Uuids;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'airport_id',
        'language',
        'description',
        'terms_and_conditions',
    ];

    /**
     * @param $query
     * @param $searchTerm
     *
     * @return mixed
     */
    public function scopeFullTextSearch($query, $searchTerm)
    {
        return $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
    }
}
