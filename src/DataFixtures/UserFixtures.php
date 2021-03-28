<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminPassword = $this->passwordEncoder->encodePassword($adminUser, 'Asse7842*');

        $adminUser->setEmail("florian@gmail.com");
        $adminUser->setPassword($adminPassword);
        $adminUser->addUserRole($adminRole);

        $manager->persist($adminUser);

        $faker = Faker\Factory::create("fr_FR");
        for($i = 0; $i < 10; $i++){

            $user = new User();

            $password = $this->passwordEncoder->encodePassword($user, 'the_new_password');
            
            $user->setEmail($faker->email);
            $user->setPassword($password);
            

            $manager->persist($user);

        }
        $manager->flush();
    }
}
