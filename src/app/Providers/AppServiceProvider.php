<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('data', function (bool $success, mixed $data, int $status = 200) {
            return Response::json([
                'success' => $success,
                'data' => $data
            ], $status);
        });

        Scramble::configure()->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::apiKey('header', 'X-Api-Key')
            );
        });

        SecurityScheme::apiKey('header', 'X-Api-Key');
    }
}
