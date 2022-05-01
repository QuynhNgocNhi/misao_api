<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\Helper;

class CustomQueryStatementServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        Builder::macro('whereLikeRaw', function ($attributes, string $searchTerm, $prefix = true, $suffix = true) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $prefix && $searchTerm = '%' . $searchTerm;
//            $suffix && $searchTerm = $searchTerm . '%';
//
//            $this->whereRaw("UPPER(" . $attributes . ") LIKE UPPER ('{$searchTerm}')");
//
//            return $this;
//        });
//        Builder::macro('orWhereLikeRaw', function ($attributes, string $searchTerm, $prefix = true, $suffix = true) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $prefix && $searchTerm = '%' . $searchTerm;
//            $suffix && $searchTerm = $searchTerm . '%';
//
//            $this->orWhereRaw("UPPER(" . $attributes . ") LIKE UPPER ('{$searchTerm}')");
//
//            return $this;
//        });
//        Builder::macro('wherePhoneNumberFirst', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*' . $searchTerm . '[0-9]*-[0-9]*-[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//
//        });
//        Builder::macro('wherePhoneNumberSecond', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*' . $searchTerm . '[0-9]*-[0-9]*-[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//        });
//        Builder::macro('wherePhoneNumberSecond', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*-[0-9]*' . $searchTerm . '[0-9]*-[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//        });
//        Builder::macro('wherePhoneNumberThird', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*-[0-9]*-[0-9]*' . $searchTerm . '[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//        });
//        Builder::macro('whereZipCodeFirst', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*' . $searchTerm . '[0-9]*-[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//
//        });
//        Builder::macro('whereZipCodeSecond', function ($attributes, string $searchTerm) {
//            $searchTerm = Helper::checkSpecialCharacter($searchTerm);
//            $regex = '^[0-9]*-[0-9]*' . $searchTerm . '[0-9]*$';
//
//            $this->whereRaw("{$attributes} REGEXP '{$regex}'");
//
//        });
    }

    public function register()
    {

    }
}
