<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;
use Log;

class Helper {
    /**
     * Generate a tfa token
     *
     * @return string
     * @throws \Exception
     */
    public static function generateTfaToken(): string
    {
        return random_int(config('constant.tfa_token_min_value'), config('constant.tfa_token_max_value'));
    }

    public static function checkSpecialCharacter($valueSearch)
    {
        $valueSearch = strpos($valueSearch, '%') !== false
            ? preg_replace('/\%/', '\%', $valueSearch)
            : $valueSearch;
        $valueSearch = strpos($valueSearch, '_') !== false
            ? preg_replace('/\_/', '\_', $valueSearch)
            : $valueSearch;
        $valueSearch = preg_match('/\\\/', $valueSearch) !== false ? addslashes($valueSearch) : $valueSearch;

        return $valueSearch;
    }

    /**
     * @param string $base64_string
     * @return bool|string
     */
    protected static function getContentBase64(string $base64_string)
    {
        if (!self::checkImageBase64($base64_string)) return false;
        $data = explode(',', $base64_string);

        return base64_decode($data[1]);
    }

    /*
    * @param string
    * @return bool
    */
    protected static function checkImageBase64($image)
    {
        return (substr($image, 0, 11) == 'data:image/') ? true : false;
    }

    /**
     * Generate a token string in response contact/document request mail
     * Example: http://form.keihan-kiss.co.jp/mail/res?id=c99999&token=12345678abcd
     *
     * @return string
     */
    public static function generateToken(): string
    {
        return str_replace(['/', '.'], '', Hash::make(config('constant.token_salt_string')));
    }
}
