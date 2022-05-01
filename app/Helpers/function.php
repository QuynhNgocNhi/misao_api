<?php
if (!function_exists('price')) {
    function price($price, $fraction = false, $isHTML = false, $class = 'md:text-xl')
    {
        $whole = (int)floor($price / 10000);
        if (!$fraction) {
            return number_format($price);
        }
        $fraction = rtrim($price - $whole * 10000, '0');
        $fraction = empty($fraction) ? '' : '.'.$fraction;
        if($isHTML){
            return number_format($whole) . '<span class="text-xs ' . $class . ' font-medium">' . $fraction . '</span>';
        }
        return number_format($whole) . $fraction;

    }
}
if (!function_exists('price_with_tax')) {
    function price_with_tax($price, $tax = 10)
    {
        if (!$price) return $price;
        $price = $price + ($price * ($tax / 100));
        return number_format($price, 0, '', '.');
    }
}
if (!function_exists('num')) {
    function num($num, string $spe = '.')
    {
        return number_format($num, 0, '', $spe);
    }
}
if (!function_exists('km')) {
    function km($km)
    {
        $number  = explode('.', strval($km));
        $decimal =  isset($number[1]) ? $number[1] : null;
        return $decimal ? number_format($number[0]) . '.' . $decimal : number_format($number[0]);
    }
}

if (!function_exists('km_to_mile')) {
    function km_to_mile($km)
    {
        if (empty($km)) return 0;
        return $km * 0.621371;
    }
}

if (!function_exists('japanese_era')) {
    function japanese_era($datetime)
    {
        $formatter = new IntlDateFormatter(
            'ja_JP@calendar=japanese',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'Asia/Tokyo',
            IntlDateFormatter::TRADITIONAL,
            'Gy' //Age and year (regarding the age)
        );

        return $formatter->format(strtotime($datetime));
    }
}

if (!function_exists('previous_url')) {
    function previous_url($routeName)
    {
        $previouseUrl     = back()->getTargetUrl();
        $backRouteName    = app('router')->getRoutes()->match(app('request')->create(back()->getTargetUrl()))->getName();
        $currentRouteName = Route::currentRouteName();

        return $backRouteName === $currentRouteName ? route($routeName) : $previouseUrl;
    }
}

if (!function_exists('list_year')) {
    function list_year($start = 1980)
    {
        $years = range(date('Y'), $start);
        $data  = [];
        foreach ($years as $year) {
            $data[$year] = $year;
        }
        return $data;
    }
}


if (!function_exists('number_with_suffix')) {
    function number_with_suffix($value, $suffix = '', $default = '')
    {
        return $value != 0 ? $value . $suffix : $default;
    }
}


