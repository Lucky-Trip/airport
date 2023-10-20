<?php

namespace Modules\V1\Languages\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Http\Responses\StatusCode;
use Modules\V1\Languages\Enums\LanguageEnum;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_ENV') == 'testing') {
            return $next($request);
        }

        $allowedLanguages = LanguageEnum::list();
        $requestedLanguage = $request->header('Accept-Language') ?? LanguageEnum::ENGLISH->value;

        if (!in_array($requestedLanguage, $allowedLanguages, true)) {
            return response()->json([
                'message' => __('languages.invalid_language')
            ], StatusCode::NOT_ACCEPTABLE->value);
        }

        app()->setLocale($requestedLanguage);

        return $next($request);
    }
}
