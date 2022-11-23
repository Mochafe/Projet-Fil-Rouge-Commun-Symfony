<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\CartDetail;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();

        $product->setName("Squier 40th Anniv. Tele SGM");

        $product->setDescription('
        Edition 40th Anniversary Gold<br>
        Corps en nyatoh<br>
        Manche en érable<br>
    ');

        $product->setPrice(325);

        $product->setQuantity(100);

        $image = new Image();

        $image->setTitle("guitar");

        $image->setPath("/img/products/a.jpg");

        $manager->persist($image);

        $product->addImage($image);

        $manager->persist($product);

        $manager->flush();
    }
}
