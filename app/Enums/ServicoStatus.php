<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ServicoStatus: string implements HasColor, HasLabel
{
    case EmAndamento = 'Em andamento';
    case Concluido = 'Concluído';
    case Interrompido = 'Interrompido';
    case Suspenso = 'Suspenso';
    case Cancelado = 'Cancelado';

    public function getLabel(): string
    {
        return match ($this) {
            self::EmAndamento => 'Em andamento',
            self::Concluido => 'Concluído',
            self::Interrompido => 'Interrompido',
            self::Suspenso => 'Suspenso',
            self::Cancelado => 'Cancelado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EmAndamento => 'gray',
            self::Concluido => 'success',
            self::Interrompido, self::Suspenso => 'warning',
            self::Cancelado => 'danger',
        };
    }
}