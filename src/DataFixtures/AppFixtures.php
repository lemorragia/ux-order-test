<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\CustomerType;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private const CUSTOMERS_TO_GENERATE = 50;
    private const PRODUCTS_TO_GENERATE = 50;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('it_IT');;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=self::CUSTOMERS_TO_GENERATE; $i++)
        {
            $this->generateCustomer($manager);
        }

        $manager->flush();

        for($i=1;$i<=self::PRODUCTS_TO_GENERATE; $i++)
        {
            $this->generateProduct($manager);
        }

        $manager->flush();
    }

    private function generateCustomer(ObjectManager $manager): void
    {
        $customer = new Customer();
        $type = rand(0,1) === 1 ? CustomerType::PERSON : CustomerType::COMPANY;
        if($type === CustomerType::PERSON) {
            $customer->lastName = $this->faker->lastName;
            $customer->firstName = $this->faker->firstName;
        } else {
            $customer->companyName = $this->faker->company;
        }
        $customer->type = $type;

        $manager->persist($customer);
    }

    private function generateProduct(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName($this->faker->jobTitle);
        $product->setSalePrice($this->faker->randomFloat(2, 10, 50));

        $manager->persist($product);
    }
}
