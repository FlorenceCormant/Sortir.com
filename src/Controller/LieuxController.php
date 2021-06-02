<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuxFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class LieuxController extends AbstractController
{

    /**
     * @Route("/createlieu", name="createlieu")
     */


   public function createLieux(Request $request, EntityManagerInterface $entityManager){


       $lieux = new Lieux();
       $form = $this->createForm(LieuxFormType::class, $lieux);
       $form->handleRequest($request);

       if ($form->isSubmitted()){
           $lieux->
           $entityManager->persist($lieux);
           $entityManager->flush();

           $this->addFlash('succes','Lieu modifié !!');
           return $this->redirectToRoute('create');
       }

        return $this->render('lieux/creerlieux.html.twig', [
           'lieuForm' => $form->createView()
       ]);
   }
}
