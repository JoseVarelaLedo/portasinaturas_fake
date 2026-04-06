<?php

namespace App\Enums;

enum EstadoDocumento: string
{
    case PENDENTE = 'pendente';
    case APORTADO = 'aportado';
    case EN_REVISION = 'en_revision';
    case VALIDADO = 'validado';
    case NON_PROCEDE = 'non_procede';
    case REXEITADO = 'rexeitado';
    case EMENDAR = 'emendar';
    case EMENDADO = 'emendado';


    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::APORTADO => 'Aportado',
            self::EN_REVISION => 'En revisión',
            self::VALIDADO => 'Validado',
            self::NON_PROCEDE => 'Non Procede',
            self::REXEITADO => 'Rexeitado',
            self::EMENDAR => 'Emendar',
            self::EMENDADO => 'Emendado',
        };
    }
}
