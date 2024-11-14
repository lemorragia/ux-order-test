<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\SaleOrder;
use App\Form\Type\AutocompleteWithAddType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class SaleOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', AutocompleteWithAddType::class, [
                'label' => 'Customer',
                'class' => Customer::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                              ->addOrderBy('c.companyName', 'ASC')
                              ->addOrderBy('c.lastName', 'ASC');
                },
                'attr' => [
                    'data-controller' => 'autocomplete',
                ],
            ])

            ->add('items', LiveCollectionType::class, [
                'entry_type' => SaleOrderItemType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])

            ->add('total', null, [
                'attr' => [
                    'readonly' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined('type');

        $resolver->setDefaults([
            'data_class' => SaleOrder::class,
        ]);
    }
}
