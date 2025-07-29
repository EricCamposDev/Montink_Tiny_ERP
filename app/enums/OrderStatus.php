<?php

namespace App\Enums;

enum OrderStatus: string {
    case PENDENTE     = 'Pendente';
    case PROCESSANDO  = 'Processando';
    case ENVIADO      = 'Enviado';
    case ENTREGUE     = 'Entregue';
    case CANCELADO    = 'Cancelado';
    case DEVOLVIDO    = 'Devolvido';

    // Método auxiliar para verificar se pode ser cancelado
    public function canCancel(): bool {
        return match($this) {
            self::PENDENTE, self::PROCESSANDO => true,
            default => false
        };
    }

    // Texto amigável opcional
    public function badgeColor(): string {
        return match($this) {
            self::PENDENTE     => 'warning',
            self::PROCESSANDO  => 'info',
            self::ENVIADO      => 'primary',
            self::ENTREGUE     => 'success',
            self::CANCELADO    => 'danger',
            self::DEVOLVIDO    => 'secondary'
        };
    }
}
