<?php

namespace Modules\V1\Languages\Enums;

use App\Http\Enums\EnumValueListing;

enum LanguageEnum: string
{
    use EnumValueListing;

    case ENGLISH = 'en';
    case GERMAN = 'de';
}
