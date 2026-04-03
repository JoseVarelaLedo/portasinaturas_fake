<?php

namespace App\Enums;

enum ProvinciaGalicia: string
{
    case A_CORUNA = 'A Coruña';
    case LUGO = 'Lugo';
    case OURENSE = 'Ourense';
    case PONTEVEDRA = 'Pontevedra';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $provincia): string => $provincia->value,
            self::cases()
        );
    }
}
