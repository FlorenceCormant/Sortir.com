<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Villes;
use App\Form\VillesFormType;
use App\Form\VillesSearchFormType;
use App\Repository\VillesRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VillesController extends AbstractController
{
    /**
     * @Route("/admin/villes/gerer", name="gerervilles")
     */


    public function gererVilles(VillesRepository  $villesRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $search = new Villes();


        $form = $this->createForm(VillesFormType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $entityManager->persist($search);
            $entityManager->flush();

            $this->addFlash('succes', 'Villes créer !!');
            return $this->redirectToRoute('gerervilles');
        }


        $form2 = $this->createForm(VillesSearchFormType::class, $search);
        $form2->handleRequest($request);
        $villes = $villesRepository->findAll();
        if ($form2->isSubmitted())  {
            $search = $form->getData();

            //Si tous les champs sont null, on retourne toutes les sorties
            if ($search->getNom()==null) {
                $villes = $villesRepository->findAll();
            }else {
                //Sinon on fait appelle à la méthode qui trie en fonction de ce qui est null et de ce qui ne l'est pas
                $villes = $villesRepository->total($search);
            }
        }

        return $this->render('villes/gererlesvilles.html.twig', [
            'villes' => $villes,
            'villesForm' => $form->createView(),
            'villesearchForm' => $form2->createView(),
        ]);

    }

    /**
     * @Route("/admin/villes/supprimer/{id}", name="supprimervilles")
     */

    public function supprimerVilles($id, EntityManagerInterface $entityManager){
        $villes = $entityManager->find(Villes::class, $id);
        $entityManager->remove($villes);
        $entityManager->flush();

        $this->addFlash('succes', 'Villes supprimer');

        return $this->redirectToRoute('gerervilles');

    }

    /**
     * @Route("/admin/villes/modifier/{id}", name="modifiervilles")
     */
    public function modifierVille($id, VillesRepository $villesRepository, EntityManagerInterface $entityManager, Request $request){

        $villes = $villesRepository->find($id);
        $form = $this->createForm(VillesFormType::class, $villes);
        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $entityManager->persist($villes);
            $entityManager->flush();

            $this->addFlash('succes','Villes créer !!');
            return $this->redirectToRoute('gerervilles');
        }

        return $this->render('villes/modifierville.html.twig', [
            'villesForm' => $form->createView()
        ]);
    }


}

