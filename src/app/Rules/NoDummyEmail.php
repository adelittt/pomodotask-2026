<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoDummyEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dummyDomains = [
            'example.com',
            'test.com',
            'dummy.com',
            'mailinator.com',
            '10minutemail.com',
            'guerrillamail.com',
            'tempmail.com',
            'yopmail.com'
        ];

        $domain = substr(strrchr($value, "@"), 1);

        if (in_array(strtolower($domain), $dummyDomains)) {
            $fail('Domain email tidak diizinkan. Silakan gunakan email aktif yang valid (seperti Gmail atau Yahoo).');
        }
    }
}
