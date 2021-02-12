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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        //Récupérer les stages enregistrés en BD
        $stages = $repositoryStage->findAllStagesEtEntreprises();

        //Envoyer les stages récupérées à la vue chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/stages_par_entreprise/{nomEntreprise}", name="pro_stage_stages_par_entreprise")
     */
    public function stagesParEntreprise(StageRepository $repositoryStage, $nomEntreprise): Response
    {
        //Récupérer les stages proposés par l'entreprise passée en paramètre
        $stages = $repositoryStage->findByNomEntrepriseQueryBuilder($nomEntreprise);

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
    public function stagesParFormation(StageRepository $repositoryStage, $nomFormation): Response
    {
        //Récupérer les stages correspondant à la formation passée en paramètre
        $stages = $repositoryStage->findByNomFormationDQL($nomFormation);

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
        $entreprises = $repositoryEntreprise->findEntreprisesAvecStage();

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
        $formations = $repositoryFormation->findFormationsAvecStage();

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

    /**
     * @Route("/ajoutEntreprise", name="pro_stage_ajout_entreprise")
     */
    public function ajoutEntreprise(): Response
    {
        //création de l'objet entreprise à ajoutEntreprise
        $entreprise = new Entreprise();

        //création du formulaire de saisie des informarions de l'entreprise
        $formulaireEntreprise = $this->createFormBuilder($entreprise)
        ->add('nom', TextType::class)
        ->add('domaine', TextType::class)
        ->add('adresse', TextType::class)
        ->add('url_site_web', UrlType::class)
        ->add('telephone', TelType::class)
        ->getForm();

        //afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stage/ajoutEntreprise.html.twig', [
            'controller_name' => 'ProStageController',
            'vueFormulaire' => $formulaireEntreprise->createView(),
        ]);
    }
}
