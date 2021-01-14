<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Repository\StageRepository;
use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Entity\Formation;
use App\Repository\FormationRepository;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        //Récupérer les stages enregistrés en BD
        $stages = $repositoryStage->findAll();

        //Envoyer les stages récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/stages_par_entreprise/{nomEntreprise}", name="pro_stage_stages_par_entreprise")
     */
    public function stagesParEntreprise(EntrepriseRepository $repositoryEntreprise, $nomEntreprise): Response
    {
        //Récupérer l'entreprise correspondant à nomEntreprise
        $entreprise = $repositoryEntreprise->findOneByNom($nomEntreprise);

        //Récupérer les stages correspondant à l'entreprise
        $stages = $entreprise->getStages();

        //Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stage/stages_par_entreprise.html.twig', [
            'controller_name' => 'ProStageController',
            'nomEntreprise' => $nomEntreprise,
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/stages_par_formation/{nomFormation}", name="pro_stage_stages_par_formation")
     */
    public function stagesParFormation(FormationRepository $repositoryFormation, $nomFormation): Response
    {
        //Récupérer la formation correspondant à nomFormation
        $formation = $repositoryFormation->findOneByNom($nomFormation);

        //Récupérer les stages correspondant à la formation
        $stages = $formation->getStages();

        //Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stage/stages_par_formation.html.twig', [
            'controller_name' => 'ProStageController',
            'nomFormation' => $nomFormation,
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
         //Récupérer les entreprises enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();

        //Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/entreprises.html.twig', [
            'controller_name' => 'ProStageController',
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function formations(FormationRepository $repositoryFormation): Response
    {
        //Récupérer les formations enregistrées en BD
        $formations = $repositoryFormation->findAll();

        //Envoyer les formations récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/formations.html.twig', [
            'controller_name' => 'ProStageController',
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stages")
     */
    public function stages(Stage $stage, $id): Response
    {
        return $this->render('pro_stage/stages.html.twig', [
            'controller_name' => 'ProStageController',
            'stage' => $stage,
        ]);
    }
}