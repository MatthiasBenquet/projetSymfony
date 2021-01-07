<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	//création de l'entité de test
        $safran = new Entreprise();

        //ajout des attributs
        $safran->setCode("0000000001");
        $safran->setNom("Safran");
        $safran->setDomaine("Aéronautique/Espace/Défense");
        $safran->setAdresse("2 Bd du Général Martial Valin");
        $safran->setUrlSiteWeb("www.safran-group.com/fr");

        $manager->persist($safran);

        $manager->flush();
    }
}
