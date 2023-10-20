<?php

namespace Modules\V1\Airports\Models\Constants;

final readonly class AirportCacheKeys
{
    public const AIRPORT_CACHE_KEY = 'airports_list_cache';
    public const AIRPORT_CACHE_TTL = 60 * 60 * 24; // 24 hours
}
