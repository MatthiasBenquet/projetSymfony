<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/signIn", name="app_signIn")
     */
    public function signIn(Request $request, EntityManagerInterface $manager): Response
    {

      //création de l'objet User à ajouter en BD
      $user = new User();

      //création du formulaire de saisie des informarions de l'utilisateur
      $formulaireUser = $this->createForm(UserType::class, $user);

      /* on demande au formulaire d'analyser la dernière requête http.
        si le tableau POST contenu dans la requête contient des variables nom, prénom, etc...
         alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte
         à l'objet $user. */
      //$formulaireUser->handleRequest($request);

      if ($formulaireUser->isSubmitted() && $formulaireUser->isValid()) {

        //$manager->persist($user);
        //$manager->flush();

        //rediriger l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('pro_stage_accueil');
    }

    //afficher la page présentant le formulaire d'ajout d'un utilsateur
    return $this->render('security/signIn.html.twig', [
        'controller_name' => 'SecurityController',
        'vueFormulaire' => $formulaireUser->createView(),
    ]);
  }
}
