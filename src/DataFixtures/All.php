<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Supplier;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class All extends Fixture
{
private UserPasswordHasherInterface $userPasswordHasher;
private ProductRepository $productRepository;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, ProductRepository $productRepository)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->productRepository = $productRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // for ($i = 0; $i < 10; $i++) {
        //     $category = new Category();
        //     $category->setName('product ' . $i);
        //     $category->setParentCategory($category);
        //     $manager->persist($category);
        // }


        // for ($i = 0; $i < 20; $i++) {
        //     $product = new Product();
        //     $product->setName('product ' . $i);
        //     $product->setCategory(mt_rand(0, 9));
        //     $manager->persist($product);
        // }


        // for ($i = 0; $i < 10; $i++) {
        //     $user = new User();
        //     $user->setName($this->faker->name())
        //         ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
        //         ->setEmail($this->faker->email())
        //         ->setRoles(['ROLE_USER'])
        //         ->setPlainPassword('password');
        // }


        // *** USERS *** //

        $user4 = new User();
            $user4
                ->setName('pro')
                ->setLastName('pro')
                ->setBirthdate(new DateTime('2022-12-12'))
                ->setPhoneNumber('0999999999')
                ->setSigninDate(new \DateTime('2022-12-12'))
                ->setVat('0.10')
                ->setEmail('pro@muse.com')
                ->setRoles(["ROLE_PRO","ROLE_CLIENT","ROLE_USER"])
                ->setPassword($this->userPasswordHasher->hashPassword($user4, '123456'))
                ->setIsVerified(true);
        $manager->persist($user4);

        $user5 = new User();
            $user5
                ->setName('client')
                ->setLastName('client')
                ->setBirthdate(new DateTime('2022-12-12'))
                ->setPhoneNumber('0999999999')
                ->setSigninDate(new \DateTime('2022-12-12'))
                ->setVat('0.20')
                ->setEmail('client@muse.com')
                ->setRoles(["ROLE_CLIENT","ROLE_USER"])
                ->setPassword($this->userPasswordHasher->hashPassword($user5, '123456'))
                ->setIsVerified(true);
        $manager->persist($user5);



        // *** CATEGORIES *** //

        $c1 = new Category();
            $c1->setName("Guitares")
               ->setParent(null);
        $manager->persist($c1);

            $c11 = new Category();
                $c11->setName("Guitares Electriques")
                ->setParent($c1);
            $manager->persist($c11);

            $c12 = new Category();
                $c12->setName("Guitares accoustiques")
                ->setParent($c1);
            $manager->persist($c12);

        $c2 = new Category();
            $c2->setName("Guitares basses")
               ->setParent(null);
        $manager->persist($c2);

            $c21 = new Category();
                $c21->setName("Guitares basses accoustiques")
                ->setParent($c2);
            $manager->persist($c21);

            $c22 = new Category();
                $c22->setName("Guitares bassesélectriques")
                ->setParent($c2);
            $manager->persist($c22);


        $c3 = new Category();
            $c3->setName("Batteries & Percussions")
            ->setParent(null);
        $manager->persist($c3);

                $c31 = new Category();
                    $c31->setName("Batteries")
                    ->setParent($c3);
                $manager->persist($c31);

                $c32 = new Category();
                    $c32->setName("Percussions")
                    ->setParent($c3);
                $manager->persist($c32);

        $c4 = new Category();
            $c4->setName("Pianos & Claviers")
            ->setParent(null);
        $manager->persist($c4);

                $c41 = new Category();
                    $c41->setName("Claviers")
                    ->setParent($c4);
                $manager->persist($c41);


                $c42 = new Category();
                    $c42->setName("Pianos")
                    ->setParent($c4);
                $manager->persist($c42);

        $c5 = new Category();
            $c5->setName("Instruments à vent")
            ->setParent(null);
        $manager->persist($c5);

        $c6 = new Category();
            $c6->setName("Instruments traditionnels")
            ->setParent(null);
        $manager->persist($c6);

        $c7 = new Category();
            $c7->setName("Matériel DJ")
            ->setParent(null);
        $manager->persist($c7);

        $c8 = new Category();
            $c8->setName("Microphones")
            ->setParent(null);
        $manager->persist($c8);

        $c9 = new Category();
            $c9->setName("Sonorisation")
            ->setParent(null);
        $manager->persist($c9);


        // *** PRODUCTS *** //

        for ($i = 0; $i < 30; $i++) {
            $product = new Product();
                $product->setName('Elec ' . $i)
                ->setCategory($c11)
                ->setPrice(mt_rand(25, 2750))
                ->setDescription(mt_rand(0, 10).' chance(s) sur 10 de devenir sourd')
                ->setReference(uniqid('G-V__'))
                ->setDiscount('0')
                ->setDiscountRate('0')
                ->setQuantity(mt_rand(1, 100));
            $manager->persist($product);
        }

        for ($i = 0; $i < 15; $i++) {
            $product = new Product();
                $product->setName('Accoustique ' . $i)
                ->setCategory($c12)
                ->setPrice(mt_rand(25, 2750))
                ->setDescription(mt_rand(0, 10).' chance(s) sur 10 de devenir sourd')
                ->setReference(uniqid('G-V__'))
                ->setDiscount('0')
                ->setDiscountRate('0')
                ->setQuantity(mt_rand(1, 100));
            $manager->persist($product);
        }

        for ($i = 0; $i < 25; $i++) {
            $product = new Product();
                $product->setName('Basse accoustique ' . $i)
                ->setCategory($c21)
                ->setPrice(mt_rand(25, 2750))
                ->setDescription(mt_rand(0, 10).' chance(s) sur 10 de devenir sourd')
                ->setReference(uniqid('G-V__'))
                ->setDiscount('0')
                ->setDiscountRate('0')
                ->setQuantity(mt_rand(1, 100));
            $manager->persist($product);
        }

        for ($i = 0; $i < 35; $i++) {
            $product = new Product();
                $product->setName('Basse ' . $i)
                ->setCategory($c22)
                ->setPrice(mt_rand(25, 2750))
                ->setDescription(mt_rand(0, 10).' chance(s) sur 10 de devenir sourd')
                ->setReference(uniqid('G-V__'))
                ->setDiscount('0')
                ->setDiscountRate('0.05')
                ->setQuantity(mt_rand(1, 100));
            $manager->persist($product);
        }



        // for ($i = 0; $i < 20; $i++) {
        //     $image1 = new Image();
        //         $image1->setTitle('Image ' . $i)
        //         ->setPath('http://picsum.photos/id/'.mt_rand(100, 230).'/100/150')
        //         ->setProduct($product->setId(mt_rand(1, 100)));
        //     $manager->persist($image1);
        // }



        $manager->flush();
    }
}
