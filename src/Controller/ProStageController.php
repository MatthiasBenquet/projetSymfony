<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(): Response
    {
        //Récupérer le Repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        //Récupérer les stages enregistrés en BD
        $stages = $repositoryStage->findAll();

        //Envoyer les stages récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function entreprises(): Response
    {
        //Récupérer le Repository de l'entité Entreprise
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

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
    public function formations(): Response
    {
        //Récupérer le Repository de l'entité Formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

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
    public function stages($id): Response
    {
        //Récupérer le Repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        //Récupérer le stage correspondant à $id
        $stage = $repositoryStage->find($id);

        return $this->render('pro_stage/stages.html.twig', [
            'controller_name' => 'ProStageController',
            'idStage' =>  $id ,
        ]);
    }
}
