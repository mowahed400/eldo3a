<?php

namespace App\Enums;

use JetBrains\PhpStorm\Pure;

enum CategoryState : int
{
    case ACTIVE = 2;
    case INACTIVE = 1;


    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }

    public static function colors(): array
    {
        return [
            self::ACTIVE->value => 'success',
            self::INACTIVE->value => 'danger'
        ];
    }

    #[Pure]
    public static function color($key): string
    {
        $key = $key instanceof self ? $key->value : $key;

        return self::colors()[$key] ?? 'primary';
    }

    #[Pure]
    public function getColor(): string
    {
        return self::color($this->value);
    }
}
