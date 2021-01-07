<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	//création d'un générateur de données Faker
    	$faker = \Faker\Factory::create('fr_FR');

    	//création de l'entité de test
        $entreprise = new Entreprise();

        //ajout des attributs
       $entreprise->setCode("1");
       $entreprise->setNom($faker->realText($maxNbChars = 10, $indexSize = 2));
       $entreprise->setDomaine($faker->realText($maxNbChars = 30, $indexSize = 2));
       $entreprise->setAdresse($faker->address());
       $entreprise->setTelephone($faker->phoneNumber());
       $entreprise->setUrlSiteWeb($faker->url());

        $manager->persist($entreprise);

        $manager->flush();
    }
}
