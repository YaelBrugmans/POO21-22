<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setPassword($this->encoder->encodePassword($user, "root"));
        $user->setEmail("user@fixtures");
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $admin = new User();

        $admin->setPassword($this->encoder->encodePassword($admin, "root"));
        $admin->setEmail("admin@fixtures");
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $categorieNames = ["XC", "Enduro", "All mountain", "Trail"];
        $categories = [];
        foreach ($categorieNames as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }

        $manager->flush();

        $advert1 = new Advert();

        $advert1->setUser($user);
        $advert1->setTitle("adv1");
        $advert1->setBikeYear(2020);
        $advert1->setCategory($categories[0]);
        $advert1->setDescription("Un velo du tonnerre.");
        $advert1->setPrice(2001);
        $manager->persist($advert1);

        $advert2 = new Advert();

        $advert2->setUser($admin);
        $advert2->setTitle("adv2");
        $advert2->setBikeYear(2017);
        $advert2->setCategory($categories[1]);
        $advert2->setDescription("Un velo encore plus du tonnerre.");
        $advert2->setPrice(2000);
        $manager->persist($advert2);
        $manager->flush();
    }
}
