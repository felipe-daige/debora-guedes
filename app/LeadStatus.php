<?php

namespace App;

enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case VisitScheduled = 'visit_scheduled';
    case Proposal = 'proposal';
    case Won = 'won';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Novo',
            self::Contacted => 'Contato realizado',
            self::Qualified => 'Qualificado',
            self::VisitScheduled => 'Visita agendada',
            self::Proposal => 'Proposta',
            self::Won => 'Fechado',
            self::Lost => 'Perdido',
        };
    }
}
