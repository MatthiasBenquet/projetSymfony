<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		//création de 2 utilisateurs à enregistrer en BD
		$perceval = new User();
		$perceval->setPrenom('Perceval');
		$perceval->setNom('de Galles');
		$perceval->setEmail('cestpasfaux@onenagros.fr');
		$perceval->setRoles(['ROLE_ADMIN']);
		$perceval->setPassword('$2y$10$Xi2jwmPXxTOIaQIvu70HuOv5fEkt5K4zOesTEGBFfxN.r.t2z1v7S');
		$manager->persist($perceval);

		$karadoc = new User();
		$karadoc->setPrenom('Karadoc');
		$karadoc->setNom('de Vannes');
		$karadoc->setEmail('legras@cestlavie.fr');
		$karadoc->setRoles(['ROLE_USER']);
		$karadoc->setPassword('$2y$10$WZc7jSX4Gocp9mbBZ4j/ceMPA6oS0r3BNfFgu5Nh.49uuyPC7gFMq');
		$manager->persist($karadoc);

    //création d'un générateur de données Faker
		$faker = \Faker\Factory::create('fr_FR');

		//création des formations
		$dutInfoAnglet = new Formation();
		$dutInfoAnglet->setNom("DUT Informatique Anglet");
		$dutInfoAnglet->setTypeFormation("DUT");
		$dutInfoAnglet->setDomaine("Informatique");
		$dutInfoAnglet->setVille("Anglet");

		$dutInfoBordeaux = new Formation();
		$dutInfoBordeaux->setNom("DUT Informatique Bordeaux");
		$dutInfoBordeaux->setTypeFormation("DUT");
		$dutInfoBordeaux->setDomaine("Informatique");
		$dutInfoBordeaux->setVille("Bordeaux");

		$lpProgAvanceeAnglet = new Formation();
		$lpProgAvanceeAnglet->setNom("Licence Professionnelle Programmation Avancée");
		$lpProgAvanceeAnglet->setTypeFormation("Licence Professionnelle");
		$lpProgAvanceeAnglet->setDomaine("Informatique");
		$lpProgAvanceeAnglet->setVille("Anglet");

		$licenceInfoBordeaux = new Formation();
		$licenceInfoBordeaux->setNom("Licence Informatique Bordeaux");
		$licenceInfoBordeaux->setTypeFormation("Licence");
		$licenceInfoBordeaux->setDomaine("Informatique");
		$licenceInfoBordeaux->setVille("Bordeaux");

		$licenceInfoToulouse = new Formation();
		$licenceInfoToulouse->setNom("Licence Informatique Toulouse");
		$licenceInfoToulouse->setTypeFormation("Licence");
		$licenceInfoToulouse->setDomaine("Informatique");
		$licenceInfoToulouse->setVille("Toulouse");

		$ecoleIngenieurNantes = new Formation();
		$ecoleIngenieurNantes->setNom("ISEN Nantes");
		$ecoleIngenieurNantes->setTypeFormation("École d'Ingénieur");
		$ecoleIngenieurNantes->setDomaine("Informatique");
		$ecoleIngenieurNantes->setVille("Nantes");

		$ecoleIngenieurLyon = new Formation();
		$ecoleIngenieurLyon->setNom("INSA Lyon");
		$ecoleIngenieurLyon->setTypeFormation("École d'Ingénieur");
		$ecoleIngenieurLyon->setDomaine("Informatique");
		$ecoleIngenieurLyon->setVille("Lyon");

		$tabFormations = array(
			$dutInfoAnglet, $dutInfoBordeaux, $lpProgAvanceeAnglet, $licenceInfoBordeaux,
			$licenceInfoToulouse, $ecoleIngenieurNantes, $ecoleIngenieurLyon
		);

		//enregistrement des formations
		foreach ($tabFormations as $formation) {
			$manager->persist($formation);
		}

		//création des entreprises
		$nbEntreprises = 10; //nombre d'entreprises à créer
		$tabEntreprises = array();

		for ($i=0; $i < $nbEntreprises; $i++) {
			//création de l'entreprise
			$entreprise = new Entreprise();

			//ajout des attributs
			$entreprise->setNom($faker->company());
			$entreprise->setDomaine($faker->jobTitle());
			$entreprise->setAdresse($faker->address());
			$entreprise->setTelephone($faker->phoneNumber());
			$entreprise->setUrlSiteWeb('www.'.$faker->domainWord().'.'.$faker->regexify('(com|fr)'));

			//ajout de l'entreprise au tableau
			$tabEntreprises[] = $entreprise;

		}

		//enregistrement des entreprises
		foreach ($tabEntreprises as $uneEntreprise) {
			$manager->persist($uneEntreprise);
		}

		//création des stages
		$nbStages = 10; //nombre de stages à créer

		for ($i = 0; $i < $nbStages; $i++) {
			//création du stage
			$stage = new Stage();

			//ajout d'attributs
			$stage->setNom($faker->regexify('(Développement |Maintenance |Conception )d\'un( logiciel\.|e application\.)'));
			$stage->setDescription($faker->realText($maxNbChars = 500, $indexSize = 2));
			$stage->setDateDebut($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timeZone = 'Europe/Paris'));
			$stage->setDuree($faker->numberBetween($min = 20, $max = 1000));
			$stage->setCompetencesRequises($faker->regexify('(PHP|C\+\+|JavaScript|Java|Symfony)'));
			$stage->setExperienceRequise($faker->regexify('(Bac\+2|Bac\+3|Bac\+5|Niveau ingénieur)'));
			$stage->setEmail($faker->email());
			$stage->setContact($faker->name());

			//ajout relation à Entreprise
			$indiceEntreprise = $faker->numberBetween($min = 0, $max = $nbEntreprises-1);
			$stage->setEntreprise($tabEntreprises[$indiceEntreprise]);

			//ajout relation à Formation
			//génération nombre de formations à ajouter
			$nbFormationsConcernees = $faker->numberBetween($min = 1, $max = 7);

			//choix des formations à ajouter
			$indicesFormationsConcernees = $faker->randomElements($array = array (0,1,2,3,4,5,6), $count = $nbFormationsConcernees);


			foreach ($indicesFormationsConcernees as $indiceFormationAAjouter) {
				//ajout de la formation
				$stage->addFormation($tabFormations[$indiceFormationAAjouter]);

				//ajout du stage à la formation
				$tabFormations[$indiceFormationAAjouter]->addStage($stage);

				//enregistrement de la formation modifiée
				$manager->persist($tabFormations[$indiceFormationAAjouter]);
			}

			//complétion des relations à Entreprise (après avoir ajouté les formations)
			$tabEntreprises[$indiceEntreprise]->addStage($stage);

			//enregistrement du stage et de l'entreprise modifiée
			$manager->persist($stage);
			$manager->persist($tabEntreprises[$indiceEntreprise]);
		}


        //envoi en base de donnée
		$manager->flush();
	}
}
