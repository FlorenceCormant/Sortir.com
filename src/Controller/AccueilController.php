<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\PropertySearch;
use App\Entity\Villes;
use App\Form\PropertySearchType;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_home")
     */
    public function home(SortiesRepository $sortiesRepository, Request $request, ParticipantsRepository  $participantsRepository, EntityManagerInterface $entityManager): Response
    {
        $search = new PropertySearch();

        $utilisateur = $this->getUser();

        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $sorties = $sortiesRepository->findAll(); //On recupere toute les sorties
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            if ($search->getNom()==null && $search->getVille() == null && $search->getDate() == null) {
                $sorties = $sortiesRepository->findAll();
            }else {
                $sorties = $sortiesRepository->form($search);
            }
        }


        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties,
            "utilisateur" => $utilisateur,
            "form" => $form->createView()
        ]);
    }
}
