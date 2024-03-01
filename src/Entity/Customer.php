<?php

namespace App\Entity;

use App\Model\IdTrait;
use App\Model\NameTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Customer
{
    use IdTrait;
    use NameTrait;
}
