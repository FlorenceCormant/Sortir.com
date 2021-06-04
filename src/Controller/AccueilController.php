<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Villes;
use App\Entity\User;
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
    public function home(SortiesRepository $sortiesRepository, Request $request): Response
    {
        $search = new PropertySearch();

        $utilisateur = $this->getUser();




        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $sorties = $sortiesRepository->findAll(); //On recupere toute les sorties
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            if ($search->getNom()==null && $search->getVille() == null) { //Si le formulaire est submit mais que les champs sont vide, on liste toute les sorties
                $sorties = $sortiesRepository->date($search);
            }else {
                $sorties = $sortiesRepository->date($search); //Sinon on appelle la methode test (voir Sortie repository)
            }
        }


        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties,
            "utilisateur" => $utilisateur,
            "form" => $form->createView()
        ]);
    }
}
