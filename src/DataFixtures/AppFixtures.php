<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setName("Squier 40th Anniv. Tele SGM");
            $product->setDescription('
        Edition 40th Anniversary Gold
        Corps en nyatoh
        Manche en érable
    ');
            $product->setPrice(325);
            $product->setQuantity(100);
            $image = new Image();
            $image->setTitle("guitar");
            $image->setPath("/img/products/a.jpg");
            $manager->persist($image);
            $product->addImage($image);
            $product->setCategory($c11);
            $manager->persist($product);
        }




        $manager->flush();
    }
}
