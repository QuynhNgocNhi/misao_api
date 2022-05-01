<?php

namespace App\Rules;

use App\Models\CarMedia;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class MinRequiredMedias implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $requiredMedias = CarMedia::whereIn('id', $value)->where('is_required_image', YES)->get();
        return count($requiredMedias) == 6;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '必須な6枚の写真が必要です。';
    }
}
