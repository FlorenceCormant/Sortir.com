<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\User;
use App\Form\ProfilFormType;
use App\Form\RegistrationFormType;
use App\ManageEntity\UpdateEntity;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use App\Upload\UserImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            'user' => $user
        ]);
    }


    /**
     * @Route("/user/{id}", name="user_profil", requirements={"id"="\d+"})
     */
    public function userProfil($id, UserRepository $userRepository)
    {

        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur inconnu');
        }
        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route ("/user/edit/{id}", name="profil_edit")
     */

    public function editProfil($id,
                               UserRepository $userRepository,
                               Request $request,
                               EntityManagerInterface $entityManager,
                               SluggerInterface $slugger,
                               UpdateEntity $updateEntity,
                               UserImage $userImage): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur inconnu');
        }

        $profilForm = $this->createForm(RegistrationFormType::class, $user);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()) {
                $photoFile = $profilForm->get('photo')->getData();

                if ($photoFile) {
                    $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $photoFile->move(
                            $this->getParameter('upload_photos_users_dir'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $user->setPhoto($newFilename);
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Profil modifié');
                return $this->redirectToRoute('user_profil', ['id' => $user->getId()]);
            }
            return $this->render('user/editProfil.html.twig', [
                "user" => $user,
                "profilForm" => $profilForm->createView()
            ]);
        }

}
