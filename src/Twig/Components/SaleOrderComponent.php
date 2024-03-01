<?php

namespace App\Twig\Components;

use App\Entity\SaleOrder;
use App\Form\SaleOrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent]
final class SaleOrderComponent extends AbstractController
{
    use ComponentToolsTrait;
    use ComponentWithFormTrait;
    use DefaultActionTrait;
    use LiveCollectionTrait;

    public function __construct(private EntityManagerInterface $entityManager){}

    #[LiveProp]
    public SaleOrder $initialFormData;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SaleOrderType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function updateProductData(): void
    {
        $orderTotal = 0;

        foreach ($this->formValues['items'] as &$item) {

            $item['unitPrice'] = rand(0, 40); //Assign a random unitPrice, just for testing

            if (empty($item['quantity'])) {
                $item['quantity'] = 1;
            }

            $this->setItemTotal($item);
            $orderTotal += $item['total'];
        }

        $this->setOrderTotal($orderTotal);
    }

    #[LiveAction]
    public function updateTotal(): void
    {
        $orderTotal = 0;

        foreach ($this->formValues['items'] as &$item) {
            $this->setItemTotal($item);
            $orderTotal += $item['total'];
        }

        $this->setOrderTotal($orderTotal);
    }

    private function setItemTotal(array &$item): void
    {
        $item['total'] = (float)$item['unitPrice'] * (float)$item['quantity'];
    }

    private function setOrderTotal(float $total): void
    {
        $this->formValues['total'] = $total;
    }
}
