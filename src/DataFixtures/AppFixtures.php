<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Livre;
use Faker\Factory;
use App\Repository\LivreRepository;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names=['INformatique','Scientifique','History','Langue','Cuisine'];
        $faker = Factory::create();       // $faker = Faker\Factory::create('fr_FR');

     
        for ($i = 0; $i < 5; $i++)
        {
            $categ = new Category();
            $categ->setName($names[$i]);
            $manager->persist($categ);
            $limit=rand(5,10);
            for ($j = 0; $j < $limit; $j++)
            {
                $livre = new Livre();
                $livre->setTitre("Livre".$j);
                $livre->setPrice(100*$j);
                $livre->setAuteur($faker->address);
                $livre->setResume($faker->word);
                $livre->setCategory($categ);
                $manager->persist($livre);  

               /* $limit = rand(1,5);
                for($k=0;$k<$limit;$k++)
                {
                    $emp=new Emprunteur();
                    $emp->setNom($faker->name);
                    $emp->setPrenom($faker->name);
                    $emp->setTelephone($faker->address);           
                    $manager->persist($four); 
                    $livre->addEmprunteur($emp);
                    $manager->persist($livre); 
                   
                }  */ 


               
            } 
        }
        $manager->flush();

            

    }
}
