<?php

declare(strict_types=1);


namespace App\Validation;

use App\Contracts\Validation\ValidatorInterface;

class ValidationHelper
{
    /**
     * @param ValidatorInterface[] $validators
     */
    public static function validateAll(array $validators, array $data): void
    {
        foreach ($validators as $validator) {
            $validator->validate($data);
        }
    }
}