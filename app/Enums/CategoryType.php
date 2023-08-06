<?php

namespace App\Enums;

use JetBrains\PhpStorm\Pure;

enum CategoryType : int
{
    case TEXT_AND_BANNER = 1;
    case IMAGE = 2;

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
            self::TEXT_AND_BANNER->value => 'success',
            self::IMAGE->value => 'danger'
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
