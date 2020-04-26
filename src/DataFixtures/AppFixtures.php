<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Livre;
//se Faker\Factory;
use Doctrine\Migrations\Version\Factory;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names=['Informatique','Kids','Sport','History','Medical'];
        $faker = Factory::create();
       
       
       //$faker = Faker\Factory::create('fr_FR');
     
        for ($i = 0; $i < 5; $i++)
        {
            $categ = new Category();
            $categ->setName($names[$i]);
            $manager->persist($categ);
            $limit=rand(5,10);
            for ($j = 0; $j < $limit; $j++)
            {
                $product = new Livre();
                $product->setTitre("Livre".$j);
                $livre->setAuteur($faker->name);
                $product->setPrice(100*$j);
                $product->setResume($faker->name);
                $product->setCategory($categ);
                $manager->persist($livre);  

                $limit = rand(1,5);
                
            } 
        }
        $manager->flush();

                   






    }
}
