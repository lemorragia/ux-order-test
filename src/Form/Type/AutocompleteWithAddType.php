<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AutocompleteWithAddType extends AbstractType
{
    /** @param array<string, mixed> $options */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'autocomplete' => true,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'autocomplete_with_add';
    }
}
