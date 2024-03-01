<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SaleOrderItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleOrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'required' => false,
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'updateProductData',
                ],
            ])
            ->add('unitPrice', NumberType::class, [
                'label' => 'unitPrice',
                'html5' => true,
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'updateTotal',
                ],
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'quantity',
                'html5' => true,
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'updateTotal',
                ],
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
        $resolver->setDefaults([
            'data_class' => SaleOrderItem::class,
        ]);
    }
}
