<?php

namespace App\DataFixtures;

use App\Entity\Evolution;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\DateTime;

class EvolutionFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user
            ->setEmail('e@gmail.com')
            ->setPassword('coucou');
        $manager->persist($user);
        $manager->flush();

        for($i = 0; $i < 200; $i++){


            $evolution = new Evolution();
            $evolution
                ->setName($faker->words(7, true))
                ->setDescription($faker->sentence(10, true))
                ->setDate(new \DateTime('now'))
                ->setUserEvolution($user);
            $manager->persist($evolution);
        }
        $manager->flush();
    }
}
