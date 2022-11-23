<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
        /**
     * @var Generator
     *
     * @var Generator
     */
    private Generator $faker;
   

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
        
    }
    public function load(ObjectManager $manager): void
    {

    
    
        $c1 = new Category();
        $c1->setName("Guitares");
        $manager->persist($c1);

        $c11 = new Category();
        $c11->setName("Guitares Electriques");
        // $c1->addCategory($c11);
        $c11->setParent($c1);
        $manager->persist($c11);

        $c12 = new Category();
        $c12->setName("Guitares Accoustiques");
        // $c1->addCategory($c12);
        $c12->setParent($c1);
        $manager->persist($c12);


        $c2 = new Category();
        $c2->setName("Percusions");
        $manager->persist($c2);

        $c3 = new Category();
        $c3->setName("Cuivres");
        $manager->persist($c3);

        $c33 = new Category();
        $c33->setName("Trompette");
        $manager->persist($c33);

    $manager->flush();
    }
}
