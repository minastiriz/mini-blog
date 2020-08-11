<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
       $this->passwordEncoder =  $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
       $fake = Factory::create('es_ES');
       for ($i=0; $i<10; $i++)
        {
            $user = new User();
            $password = $this->passwordEncoder->encodePassword($user, "password");
            $user->setEmail($fake->email);
            $user->setPassword($password);
            $manager->persist($user);

            for ($j = 0; $j<random_int(5,15); $j++){
                $article = new Article();
                $article->setAuthor($user);
                $article ->setName($fake->text(50));
                $article ->setContent($fake->text(200));
                $manager->persist($article);

            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
