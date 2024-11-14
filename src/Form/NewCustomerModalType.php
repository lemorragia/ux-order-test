<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Customer;
use App\Entity\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCustomerModalType extends AbstractType
{
    /** @param array<string, mixed> $options */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['type'] === 'person') {
            $builder
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class);
        } elseif ($options['type'] === 'company') {
            $builder
                ->add('companyName', TextType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined('type');

        $resolver->setDefaults([
            'data_class' => Customer::class,
            'validation_groups' => static function (FormInterface $form) {
                $data = $form->getConfig()->getOption('type');
                if ($data === CustomerType::PERSON->value) {
                    return ['Default', CustomerType::PERSON->value];
                }

                return ['Default', CustomerType::COMPANY->value];
            },
        ]);
    }
}
