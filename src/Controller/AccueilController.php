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
    public function home(SortiesRepository $sortiesRepository, VillesRepository $villesRepository, Request $request): Response
    {
        $search = new PropertySearch();


        $villes = $villesRepository->findAll();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $search = $form->getData();
        }
        if ($search->getNom() == null) {
            $sorties = $sortiesRepository->findAll();
        } else {
            $sorties = $sortiesRepository->rechercher($search);
        }

        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties,
            "villes" => $villes,
            "form" => $form->createView()
        ]);
    }
}
