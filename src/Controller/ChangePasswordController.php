<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ChangePassword;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ChangePasswordController extends AbstractController
{
    /**
     * @Route ("/user/edit/changePassword", name="change_Password")
     */
    public function changePassword(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $resetPassword = new ChangePassword();

        $changePasswordForm = $this->createForm(ChangePasswordType::class, $resetPassword);

        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {

            //encode le nouveau password
            $this->getUser()->setPassword(
                $passwordEncoder->encodePassword(
                    $this->getUser(),
                    $changePasswordForm->get('newPassword')->getData()
                )
            );

            $this->addFlash('success', 'Mot de passe modifié avec succès');
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('profil_edit', ['id' => $user->getId()]);

        }

        return $this->render(
            'changePassword/changePassword.html.twig',
            ['ChangePasswordFormView' => $changePasswordForm->createView()
            ]);
    }
}
