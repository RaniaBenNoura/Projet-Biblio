<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Bibliotheque;
use Faker;
use Faker\Provider\Base;


class BibliothequeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $faker = Faker\Factory::create('fr_FR');
            for ($i=0; $i < 10; $i++)
            {
            $bibliotheque = new Bibliotheque();     
            $bibliotheque->setAdresse($faker->name);
          
            $manager->persist($bibliotheque);    
            }
            $this->addReference("bibliotheque", $bibliotheque);
            $manager->flush();
    }
}