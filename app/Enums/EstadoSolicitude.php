<?php

namespace App\Enums;

enum EstadoSolicitude: string
{
    case PRESENTADA = 'presentada';
    case EN_PROCESO = 'en_proceso';
    case DESISTIDA = 'desistida';
    case DENEGADA = 'denegada';
    case EMENDAR = 'emendar';
    case APROBADA = 'aprobada';

    public function label(): string
    {
        return match ($this) {
            self::PRESENTADA => 'Presentada',
            self::EN_PROCESO => 'En proceso',
            self::DESISTIDA => 'Desistida',
            self::DENEGADA => 'Denegada',
            self::EMENDAR => 'Emendar',
            self::APROBADA => 'Aprobada',
        };
    }

    public function isNoEmendable(): bool
    {
        return in_array($this, [
            self::DENEGADA,
            self::DESISTIDA,
            self::APROBADA,
        ]);
    }
}
