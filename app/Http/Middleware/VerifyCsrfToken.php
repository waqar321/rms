<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Str;
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Exclude routes that start with /api/
        '/api/*',
    ];

    public function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/' && Str::startsWith($request->path(), $except)) {
                return true;
            }
        }

        return false;
    }
}
