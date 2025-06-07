<?php

namespace App\Enum\Core;

enum BankOperationType: string
{
    case CARD = "card";
    case CHECK = "check";
    case TRANSFER = "transfer";
    case DIRECT_DEBIT = "direct_debit";
    case DEPOSIT = "deposit";
    case WITHDRAWAL = "withdrawal";
    case DEFERRED_DEBIT_CARD = "deferred_debit_card";
    case UNKNOWN = "unknown";

    public function label(): string
    {
        return match ($this) {
            BankOperationType::CARD => 'Carte',
            BankOperationType::CHECK => 'Chèque',
            BankOperationType::TRANSFER => 'Virement',
            BankOperationType::DIRECT_DEBIT => 'Prélèvement Bancaire',
            BankOperationType::DEPOSIT => "Dépot",
            BankOperationType::WITHDRAWAL => 'Retrait',
            BankOperationType::DEFERRED_DEBIT_CARD => 'Débit Différé',
            BankOperationType::UNKNOWN => 'INCONNUE',
        };
    }
}
