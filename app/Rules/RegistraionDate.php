<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class RegistraionDate implements Rule
{
    protected $error;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->error = '入力された車検日は正しくありません。';
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
        if(!$value) return true;
        $registrationDate = explode('-', $value);
        $year  = $registrationDate[0];
        $month = $registrationDate[1];
        $day   = $registrationDate[2];
        if(empty($year)){
            $this->error = '車検日の年が入力されていません。';
            return false;
        }else if(empty($month) && empty($day)){
            return $this->validateDate($year, 'Y');
        }else if(empty($month) && !empty($day)){
            $this->error = '車検日の月が入力されていません。';
            return false;
        }else if(!empty($month) && empty($day)){
            return $this->validateDate($year . '-' . str_pad($month,2,"0", STR_PAD_LEFT), 'Y-m');
        }else{
            return $this->validateDate($year . '-' . str_pad($month,2,"0", STR_PAD_LEFT) . '-' . str_pad($day,2,"0", STR_PAD_LEFT), 'Y-m-d');
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }

    public function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
