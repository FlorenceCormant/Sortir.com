<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Form\InscriptionFormType;
use App\Repository\SortiesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription/create/{id}", name="inscription")
     */
    public function createInscription($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser()->getId;



        $inscription = new Inscriptions();

        $sortie = $sortiesRepository->find($id);

        $nbInscription = $sortie->getInscriptions();
        $nombreInscritionMax = $sortie->getNbInscriptionsMax();

        $inscription = new Inscriptions();

           $inscription->addNoParticipant($userRepository->findOneBy(['id' => $user]));
            $inscription->setDateInscription(new \DateTime());
            $inscription->setNoSortie($sortie);

            $entityManager->persist($inscription);
            $entityManager->flush();


        return $this->redirectToRoute('accueil_home');
    }
}
