<?php

namespace App\Entity;

use App\Model\IdTrait;
use App\Model\NameTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    use IdTrait;
    use NameTrait;

    #[ORM\Column]
    private ?float $salePrice = null;

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function setSalePrice(float $salePrice): void
    {
        $this->salePrice = $salePrice;
    }
}
