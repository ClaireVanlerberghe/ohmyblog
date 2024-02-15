<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
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

        //Utilisateur
        $claire = new Utilisateur();
        $claire->setEmail('vanlerberghe24@gmail.com');
        $hash = $this->passwordHasher->hashPassword($claire, 'chocolat');
        $claire->setPassword($hash);
        $claire->setNom('Vanlerberghe');
        $claire->setPrenom('Claire');
        $manager->persist($claire);

        //Utilisateur
        $marie = new Utilisateur();
        $marie->setEmail('marie.e.geneste@gmail.com');
        $hash = $this->passwordHasher->hashPassword($marie, 'azerty');
        $marie->setPassword($hash);
        $marie->setNom('Geneste');
        $marie->setPrenom('Marie');
        $manager->persist($marie);

        //Catégorie cuisine française
        $france = new Categorie();
        $france->setNom('Cuisine française');
        $manager->persist($france);

        //Catégorie cuisine française
        $asie = new Categorie();
        $asie->setNom('Cuisine asiatique');
        $manager->persist($asie);   

        //Catégorie cuisine française
        $revisite = new Categorie();
        $revisite->setNom('Cuisine revisitée');
        $manager->persist($revisite);
        
        //Catégorie cuisine française
        $dessert = new Categorie();
        $dessert->setNom('Dessert');
        $manager->persist($dessert);



        $manager->flush();
    }
}
