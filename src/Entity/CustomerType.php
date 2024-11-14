<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum CustomerType: string implements TranslatableInterface
{
    case COMPANY = 'company';
    case PERSON = 'person';

    public function trans(TranslatorInterface $translator, string|null $locale = null): string
    {
        return $this->value;
    }
}
