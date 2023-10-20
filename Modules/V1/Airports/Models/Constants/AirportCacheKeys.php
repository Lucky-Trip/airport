<?php

namespace Modules\V1\Airports\Models\Constants;

final readonly class AirportCacheKeys
{
    public const AIRPORT_TAG = 'airports';
    public const SINGLE_AIRPORT_CACHE_KEY = 'airport_cache_key';
    public const AIRPORT_CACHE_TTL = 60 * 60 * 24; // 24 hours
}
