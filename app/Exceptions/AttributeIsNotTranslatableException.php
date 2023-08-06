<?php

namespace App\Exceptions;

use Exception;

class AttributeIsNotTranslatableException extends Exception
{
    public static function make(string $key, $model): AttributeIsNotTranslatableException
    {
        $translatableAttributes = implode(', ', $model->getTranslatableAttributes());

        return new static("Cannot translate attribute `{$key}` as it's not one of the translatable attributes: `$translatableAttributes`");
    }
}
