<?php

namespace App\Twig\Components;

use App\Entity\Customer;
use App\Entity\SaleOrder;
use App\Form\SaleOrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
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
    public string|null $type = null;

    #[LiveProp]
    public SaleOrder|null $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SaleOrderType::class, $this->initialFormData, [
            'type' => $this->type,
        ]);
    }

    #[LiveListener('customerCreated')]
    public function onCustomerCreated(
        #[LiveArg]
        Customer $customer,
    ): void {
        $this->formValues['customer'] = $customer->getId();
        $this->dispatchBrowserEvent('tom-select:sync');

        $this->emit('resetModal');
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
