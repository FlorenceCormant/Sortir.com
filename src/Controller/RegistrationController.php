<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\User;
use App\Form\ProfilFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder //,
        //    GuardAuthenticatorHandler $guardHandler,
        //  AppAuthenticator $authenticator
    ): Response
    {
        $user = new Participants();
        $registrationForm = $this->createForm(RegistrationFormType::class, $user);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $registrationForm->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email


            /*   return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            ); */

            return $this->redirectToRoute('accueil_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $registrationForm->createView(),
            'user'=>$user
        ]);
    }


    /**
     * @Route("/user/{id}", name="user_profil", requirements={"id"="\d+"})
     */
    public function userProfil($id, UserRepository $userRepository)
    {

        $user = $userRepository->find($id);
        dump($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur inconnu');
        }
        return $this->render('user/profil.html.twig', [
            'user'=> $user
        ]);
    }






}
