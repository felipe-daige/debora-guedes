<?php

namespace App;

enum PropertyStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Reserved = 'reserved';
    case Sold = 'sold';
    case Rented = 'rented';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Rascunho',
            self::Published => 'Publicado',
            self::Reserved => 'Reservado',
            self::Sold => 'Vendido',
            self::Rented => 'Alugado',
            self::Archived => 'Arquivado',
        };
    }
}
