<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $claire = new Utilisateur();
        $claire->setEmail('vanlerberghe24@gmail.com');
        $hash = $this->passwordHasher->hashPassword($claire, 'chocolat');
        $claire->setPassword($hash);
        $claire->setNom('Vanlerberghe');
        $claire->setPrenom('Claire');
        $manager->persist($claire);

        $manager->flush();
    }
}
