<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Helper
{

    const TOKEN_HANDLER = 'Bearer';
    const TOKEN_LEN = 128;

    /**
     * 128 Karakter uzunluğunda bir token oluşturur
     * 
     * @return string
     */
    public static function createToken()
    {
        return Str::random(self::TOKEN_LEN);
    }
}
