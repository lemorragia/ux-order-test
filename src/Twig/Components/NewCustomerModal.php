<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\Customer;
use App\Entity\CustomerType;
use App\Form\NewCustomerModalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveResponder;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use ValueError;

use function assert;

#[AsLiveComponent]
final class NewCustomerModal extends AbstractController
{
    use ComponentWithFormTrait;
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->initialFormData = new Customer();
    }

    #[LiveProp]
    public Customer $initialFormData;

    /** @var array<string,mixed> */
    #[LiveProp]
    public array $context = [];

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(NewCustomerModalType::class, $this->initialFormData, ['type' => $this->context['type']]);
    }

    #[LiveAction]
    public function saveCustomer(LiveResponder $liveResponder): void
    {
        try {
            $customerType = CustomerType::from($this->context['type']);
        } catch (ValueError) {
            throw new UnprocessableEntityHttpException('Unable to handle customerType of type: ' . $this->context['type']);
        }


        $this->initialFormData->type = $customerType;
        $this->submitForm();

        $this->entityManager->persist($this->initialFormData);
        $this->entityManager->flush();

        $this->resetValidation();

        $this->dispatchBrowserEvent('modal:close');

        $this->emit('customerCreated', [
            'customer' => $this->initialFormData->getId(),
        ]);
    }

    #[LiveListener('resetModal')]
    public function onModalToReset(): void {
        $this->formValues['firstName'] = '';
        $this->formValues['lastName'] = '';
        $this->formValues['companyName'] = '';
    }
}
