<?php

namespace App\Http\Middleware;

use Closure;
use \App\Device;
use \App\Utils\Responser;
use App\Utils\Helper;

class CheckToken
{
    /**
     * Headerda bulunan `Bearer` anahtarının taşıdığı token kontrolünü sağlar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->header(Helper::TOKEN_HANDLER, null);

        $check = Device::token((string) $token)->exists();

        if ($check) {
            return $next($request);
        }

        abort(403, Responser::MSG_TOKEN_NOT_FOUND);
    }
}
