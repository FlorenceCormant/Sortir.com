<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\PropertySearch;
use App\Entity\User;
use App\Entity\Villes;
use App\Form\PropertySearchType;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Repository\UserRepository;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//ggg
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil_home")
     */
    public function home(SortiesRepository $sortiesRepository, Request $request, ParticipantsRepository  $participantsRepository, EntityManagerInterface $entityManager ): Response
    {
        $search = new PropertySearch();

        $utilisateur = $this->getUser();

        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $sorties = $sortiesRepository->findAll(); //On recupere toute les sorties
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            //Si tous les champs sont null, on retourne toutes les sorties
            if ($search->getNom()==null && $search->getVille() == null && $search->getDate() == null && $search->getOrga() == null && $search->getPasse() == null && $search->getInscrit() == null && $search->getPasInscrit() == null) {
                $sorties = $sortiesRepository->findAll();
            }else {
                //Sinon on fait appelle à la méthode qui trie en fonction de ce qui est null et de ce qui ne l'est pas
                $sorties = $sortiesRepository->total($search,$utilisateur);
            }
        }

        return $this->render('accueil/home.html.twig', [
            "sorties" => $sorties,
            "utilisateur" => $utilisateur,
            "form" => $form->createView()
        ]);
    }
}
