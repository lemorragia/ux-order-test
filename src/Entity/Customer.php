<?php

namespace App\Entity;

use App\Model\IdTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Customer
{
    use IdTrait;

    public function __toString(): string
    {
        if($this->type === null) {
            return '-';
        }

        if($this->type === CustomerType::PERSON)
        {
            if ($this->lastName === null || $this->firstName === null) {
                return '-';
            }

            return $this->lastName . ' ' . $this->firstName;
        }

        if($this->type === CustomerType::COMPANY)
        {
            return $this->companyName ?? '-';
        }

        return '-';
    }

    #[Assert\NotNull]
    #[ORM\Column(type: Types::STRING, nullable: true, enumType: CustomerType::class)]
    public CustomerType|null $type = null;

    #[Assert\NotBlank(groups: ['person'])]
    #[ORM\Column(nullable: true)]
    public string|null $lastName = null;

    #[Assert\NotBlank(groups: ['person'])]
    #[ORM\Column(nullable: true)]
    public string|null $firstName = null;

    #[Assert\NotBlank(groups: ['company'])]
    #[ORM\Column(nullable: true)]
    public string|null $companyName = null;
}
