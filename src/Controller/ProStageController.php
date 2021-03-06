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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;

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
    public function ajoutEntreprise(Request $request, EntityManagerInterface $manager): Response
    {

        //création de l'objet entreprise à ajoutEntreprise
        $entreprise = new Entreprise();

        //création du formulaire de saisie des informarions de l'entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        /* on demande au formulaire d'analyser la dernière requête http.
           si le tableau POST contenu dans la requête contient des variables nom, domaine, etc...
           alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte
           à l'objet $entreprise. */
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()) {

          $manager->persist($entreprise);
          $manager->flush();

          //rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('pro_stage_accueil');

        }

        //afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stage/ajoutModifEntreprise.html.twig', [
            'controller_name' => 'ProStageController',
            'vueFormulaire' => $formulaireEntreprise->createView(),
            'action' => "ajouter",
        ]);
    }

    /**
     * @Route("/modificationEntreprise/{id}", name="pro_stage_modification_entreprise")
     */
    public function modificationEntreprise(Request $request, EntityManagerInterface $manager, Entreprise $entreprise): Response
    {
        //création du formulaire de modifier les informarions de l'entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        /* on demande au formulaire d'analyser la dernière requête http
           si le tableau POST contenu dans la requête contient des variables nom, domaine, etc...
           alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte
           à l'objet $entreprise. */
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()) {

          $manager->persist($entreprise);
          $manager->flush();

          //rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('pro_stage_accueil');

        }

        //afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stage/ajoutModifEntreprise.html.twig', [
            'controller_name' => 'ProStageController',
            'vueFormulaire' => $formulaireEntreprise->createView(),
            'action' => "modifier",
        ]);
    }

    /**
     * @Route("/ajoutStage", name="pro_stage_ajout_stage")
     */
    public function ajoutStage(Request $request, EntityManagerInterface $manager): Response
    {

        //création de l'objet entreprise à ajoutEntreprise
        $stage = new Stage();

        //création du formulaire de saisie des informarions de l'entreprise
        $formulaireStage = $this->createForm(StageType::class, $stage);

        /* on demande au formulaire d'analyser la dernière requête http.
           si le tableau POST contenu dans la requête contient des variables nom, domaine, etc...
           alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte
           à l'objet $entreprise. */
        $formulaireStage->handleRequest($request);

        if ($formulaireStage->isSubmitted() && $formulaireStage->isValid()) {

          $manager->persist($stage);
          $manager->flush();

          //rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('pro_stage_accueil');

        }

        //afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stage/ajoutStage.html.twig', [
            'controller_name' => 'ProStageController',
            'vueFormulaire' => $formulaireStage->createView(),
            'action' => "ajouter",
        ]);
    }
}
