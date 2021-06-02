<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\SortiesRepository;
use App\Repository\VillesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_home")
     */
    public function home(SortiesRepository $sortiesRepository,VillesRepository $villesRepository, Request $request): Response
    {
        $sorties = $sortiesRepository->findAll();
        $villes = $villesRepository->findAll();
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);


        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties,
            "villes" => $villes,
            "form" =>$form->createView()

        ]);
    }
}
