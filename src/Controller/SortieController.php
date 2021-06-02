<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortieFormType;

use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;




class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function createSortie(Request $request,EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sorties();
        $form = $this->createForm(SortieFormType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($sortie);
            $entityManager->flush();


            $this->addFlash('succes','Annonce modifié !!');
            return $this->redirectToRoute('accueil_home');
        }



        return $this->render('sortie/createsortie.html.twig', [
            'sortieForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/sortie/detail/{id}", name="detailsortie")
     */
    public function detailsortie($id, SortiesRepository $sortiesRepository){

        $sortie = $sortiesRepository->find($id);

        return $this->render('sortie/affichersortie.html.twig',[
           'detailsortie' => $sortie
            ]);

    }


    /**
     * @Route("/sortie/modification/{id}", name="modificationsortie")
     */
    public function modifiersortie($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository){

        $sortie = $sortiesRepository->find($id);
        $form = $this->createForm(SortieFormType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManager->persist($sortie);
            $entityManager->flush();
        }



        return $this->render('sortie/modifiersortie.html.twig', [
            'sortieForm' => $form->createView(),
            'suppsortie' => $sortie
        ]);

    }
    /**
     * @Route("/sortie/supprimer/{id}", name="supprimersortie")
     */

    public function supprimerSortie($id, EntityManagerInterface $entityManager){
    $sortie = $entityManager->find(Sorties::class, $id);
    $entityManager->remove($sortie);
    $entityManager->flush();

        $this->addFlash('sucess', 'Sortie supprimer');

        return $this->redirectToRoute('accueil_home');

    }

    /**
     * @Route("/sortie/annuler/{id}", name="annulersortie")
     */
    public function annulerSortie($id, SortiesRepository $sortiesRepository){

        $sortie = $sortiesRepository->find($id);

        return $this->render('sortie/annulersortie.hmtl.twig',[
            'detailsortie' => $sortie
        ]);
    }

}
