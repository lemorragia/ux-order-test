<?php

namespace App\Entity;

use App\Model\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SaleOrder
{
    use IdTrait;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\OneToMany(targetEntity: SaleOrderItem::class, mappedBy: 'saleOrder', orphanRemoval: true, cascade: ['persist','remove'])]
    private Collection $items;

    #[ORM\Column]
    private ?float $total = null;

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return Collection<int, SaleOrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(SaleOrderItem $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSaleOrder($this);
        }
    }

    public function removeItem(SaleOrderItem $item): void
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSaleOrder() === $this) {
                $item->setSaleOrder(null);
            }
        }
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }
}
