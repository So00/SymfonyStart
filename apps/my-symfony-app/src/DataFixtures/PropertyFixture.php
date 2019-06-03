<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $property = new Property;
            $property
                ->setAdress($faker->streetAddress())
                ->setBedrooms($faker->numberBetween(1,5))
                ->setCity($faker->city())
                ->setCreatedAt(new \DateTime)
                ->setDescription($faker->sentences(6, true))
                ->setFloor($faker->numberBetween(0,9))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setPostalCode($faker->postcode())
                ->setPrice($faker->numberBetween(75000,600000))
                ->setRooms($faker->numberBetween(1,5))
                ->setSold(false)
                ->setSurface($faker->numberBetween(20,350))
                ->setTitle($faker->word($faker->numberBetween(5,20), true));
            $manager->persist($property);
        }
        $manager->flush();
    }
}
