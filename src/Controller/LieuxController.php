<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuparvilleformType;
use App\Form\LieuxFormType;
use App\Form\ModifierLieuFormType;
use App\Form\TrierLieuxFormType;
use App\Repository\LieuxRepository;
use App\Repository\VillesRepository;
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

           $entityManager->persist($lieux);
           $entityManager->flush();

           $this->addFlash('succes','Lieu modifié !!');
           return $this->redirectToRoute('create');
       }

        return $this->render('lieux/creerlieux.html.twig', [
           'lieuForm' => $form->createView()
       ]);
   }

    /**
     * @Route("/ajouterlieu/{id}", name="ajouterunlieu")
     */

    public function lieuxparville( LieuxRepository $lieuxRepository,VillesRepository $villesRepository,Request $request, EntityManagerInterface $entityManager, $id){


        $ville = $villesRepository->find($id);

       $search = new Lieux();
       $form = $this->createForm(LieuparvilleformType::class, $search);
       $form->handleRequest($request);

        if ($form->isSubmitted()){

            $search->setNoVille($ville);

            $entityManager->persist($search);
            $entityManager->flush();

            $this->addFlash('succes','Lieu créer !!');
            return $this->redirectToRoute('ajouterunlieu', ['id' => $id]);
        }

        $form2 = $this->createForm(TrierLieuxFormType::class, $search);
        $form2->handleRequest($request);
        $lieux = $lieuxRepository->chercherlieuparville($ville);
        if ($form2->isSubmitted())  {
            $search = $form->getData();

            //Si tous les champs sont null, on retourne toutes les sorties
            if ($search->getNom()==null) {
                $lieux = $lieuxRepository->chercherlieuparville($ville);
            }else {
                //Sinon on fait appelle à la méthode qui trie en fonction de ce qui est null et de ce qui ne l'est pas
                $lieux = $lieuxRepository->total($search, $ville);
            }
        }


        return $this->render('lieux/lieuparville.hmtl.twig', [

           'ville' => $ville,
           'lieu' => $lieux,
           'lieuForm' => $form->createView(),
           'lieuxSearchForm' => $form2->createView(),
       ]);


   }
    /**
     * @Route("/lieu/supprimer/{id}", name="supprimerlieu")
     */

    public function supprimerLieu($id, EntityManagerInterface $entityManager, LieuxRepository $lieuxRepository){

        $lieux = $lieuxRepository->find($id);
        $idretour =  $lieux->getNoVille();
        $lieu = $entityManager->find(Lieux::class, $id);


        $entityManager->remove($lieu);
        $entityManager->flush();

        $this->addFlash('succes', 'Lieu supprimer');

        return $this->redirectToRoute('ajouterunlieu', ['id' => $idretour->getId()]);

    }

    /**
     * @Route("/lieu/modifier/{id}", name="modifierlieux")
     */


    public function modifierVille($id, LieuxRepository $lieuxRepository, EntityManagerInterface $entityManager, Request $request){


        $lieu = $lieuxRepository->find($id);
       $idretour =  $lieu->getNoVille();
        $form = $this->createForm(ModifierLieuFormType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $entityManager->persist($lieu);
            $entityManager->flush();

            $this->addFlash('succes','Villes créer !!');
            return $this->redirectToRoute('ajouterunlieu', ['id' => $idretour->getId()]);
        }

        return $this->render('lieux/modifierlieu.html.twig', [
            'lieuForm' => $form->createView(),
            'lieu' => $lieu
        ]);
    }

}
