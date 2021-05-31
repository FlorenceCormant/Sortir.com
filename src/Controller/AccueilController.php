<?php

namespace App\Controller;


use App\Entity\Sorties;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_home")
     */
    public function home(EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository): Response
    {
        $sortiesRepository = $this->getDoctrine()->getRepository(Sorties::class);
        $sortiesRepository = $entityManager->getRepository(Sorties::class);
        $sorties = $sortiesRepository->findAll();

        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties
        ]);
    }
}
