<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Form\InscriptionFormType;
use App\Repository\EtatsRepository;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticipantRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription/create/{id}", name="inscription")
     */
    public function createInscription($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository,
                                      ParticipantsRepository $participantRepository,EtatsRepository $etatsRepository, UserRepository $userRepository): Response
    {
        $userid = $this->getUser()->getId();

        $user = $participantRepository->find($userid);


        $sortie = $sortiesRepository->find($id);

        $nbInscription = $sortie->getInscriptions();
        $nombreInscritionMax = $sortie->getNbInscriptionsMax();

        $etat = $etatsRepository->find(2);


        if (count($nbInscription) < $nombreInscritionMax) {
            $inscription = new Inscriptions();
            $inscription->setUserinscription($user);
            $inscription->setDateInscription(new \DateTime());
            $inscription->setNoSortie($sortie);

            if (count($nbInscription)+1 === $nombreInscritionMax){
                $sortie->setNoEtat($etat);
                $entityManager->flush();
            }

            $entityManager->persist($inscription);
            $entityManager->flush();

        }

        return $this->redirectToRoute('accueil_home');
    }


    /**
     * @Route("/inscription/delete/{id}", name="deleteinscription")
     */
    public function desistement($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository,
                                ParticipantsRepository $participantRepository,InscriptionsRepository $inscriptionsRepository,EtatsRepository $etatsRepository, UserRepository $userRepository){


        $userid = $this->getUser()->getId();
        $user = $participantRepository->find($userid);

        $sortie = $sortiesRepository->find($id);
        $numeroetat = $sortie->getNoEtat()->getId();
        $etat = $etatsRepository->find(1);

        $nbInscription = $sortie->getInscriptions();
        $nombreInscritionMax = $sortie->getNbInscriptionsMax();

        if (count($nbInscription)-1 < $nombreInscritionMax && $numeroetat === 2){

            $sortie->setNoEtat($etat);
            $entityManager->persist($sortie);
        }

        $inscriptionsupprimer = $inscriptionsRepository->deleteSortie($id, $user);

        foreach ($inscriptionsupprimer as $suppresion){
            $entityManager->remove($suppresion);
        }
        $entityManager->flush();

        return $this->redirectToRoute('accueil_home');
    }

}
