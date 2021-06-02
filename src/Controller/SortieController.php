<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortieFormType;

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
        }



        return $this->render('sortie/createsortie.html.twig', [
            'sortieForm' => $form->createView()
        ]);

    }
}
