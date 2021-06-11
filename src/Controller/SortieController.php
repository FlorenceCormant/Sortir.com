<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Form\AnnulationFormType;
use App\Form\SortieFormType;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\s;


class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function createSortie(Request $request,EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $date = new \DateTime();

        $maValeur = $request->request->get("valeurenregistrer");
        $etatpasser = 2;

        $userid = $this->getUser()->getId();

        $sortie = new Sorties();

        $organisateur = $this->getDoctrine()->getManager()
            ->getRepository(Participants::class)
             ->find($userid);



        $sortie->setOrganisateur($organisateur);


        $sortieForm = $this->createForm(SortieFormType::class, $sortie);
        $sortieForm->handleRequest($request);


        if($sortieForm->isSubmitted() && $sortieForm->isValid()){


            if($sortie->getDateCloture() > $date){
                $etat = $this->getDoctrine()
                    ->getRepository(Etats::class)
                    ->find($etatpasser);
                $sortie->setNoEtat($etat);
            }else{
                $etat = $this->getDoctrine()
                    ->getRepository(Etats::class)
                    ->find($maValeur);
                $sortie->setNoEtat($etat);
            }



            //ajout photo
            $photoFile = $sortieForm->get('photo')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('upload_photos_sorties_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $sortie->setPhoto($newFilename);
            }


            $entityManager->persist($sortie);
            $entityManager->flush();


            $this->addFlash('succes','Annonce modifié !!');
            return $this->redirectToRoute('accueil_home');
        }



        return $this->render('sortie/createsortie.html.twig', [
            'sortieForm' => $sortieForm->createView()
        ]);

    }


    /**
     * @Route("/sortie/detail/{id}", name="detailsortie")
     */
    public function detailsortie($id, SortiesRepository $sortiesRepository, InscriptionsRepository $inscriptionsRepository){

        $utilisateur = $this->getUser();

        $sortie = $sortiesRepository->find($id);

        $inscription = $inscriptionsRepository->recupererParticipant($id);

        return $this->render('sortie/affichersortie.html.twig',[
           'detailsortie' => $sortie,
            'detail' => $inscription,
            'utilisateur' =>$utilisateur,
            ]);

    }


    /**
     * @Route("/sortie/modification/{id}", name="modificationsortie")
     */
    public function modifiersortie($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository,SluggerInterface $slugger){
        $maValeur = $request->request->get("valeurenregistrer");

        $userid = $this->getUser()->getId();
        $organisateur = $this->getDoctrine()->getManager()
            ->getRepository(Participants::class)
            ->find($userid);

        $sortie = $sortiesRepository->find($id);
        $sortie->setOrganisateur($organisateur);

        $form = $this->createForm(SortieFormType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $etat = $this->getDoctrine()
                ->getRepository(Etats::class)
                ->find($maValeur);

            $sortie->setNoEtat($etat);

            //modification photo
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
                try {
                    $photoFile->move(
                        $this->getParameter('upload_photos_sorties_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $sortie->setPhoto($newFilename);
            }


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes','Annonce modifié !!');
            return $this->redirectToRoute('accueil_home');
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
    public function annulerSortie($id, Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository): Response{

        $userid = $this->getUser()->getId();
        $organisateur = $this->getDoctrine()->getManager()
            ->getRepository(Participants::class)
            ->find($userid);

        $sortie = $sortiesRepository->find($id);
        $sortie->setOrganisateur($organisateur);
        $form = $this->createForm(AnnulationFormType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $etat = $this->getDoctrine()
                ->getRepository(Etats::class)
                ->find(5);

            $sortie->setNoEtat($etat);


            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('succes','Annonce annuler !!');
            return $this->redirectToRoute('accueil_home');
        }



        return $this->render('sortie/annulersortie.html.twig', [
            'annulForm' => $form->createView(),
            'annulsortie' => $sortie
        ]);


    }


    /**
     * @Route("/sortie/detailparticipant/{id}", name="detailparticipant")
     */
    public function detailparticipant($id, SortiesRepository $sortiesRepository){

        $sortie = $sortiesRepository->find($id);

        return $this->render('sortie/afficherparticipant.html.twig',[
            'detailparticipant' => $sortie
        ]);

    }

    /**
     * @Route("/sortie/detailutilisateur/{id}", name="detailutilisateur")
     */
    public function detailutilisateur($id, SortiesRepository $sortiesRepository, UserRepository  $userRepository){

        $sortie = $sortiesRepository->find($id);
        $user = $userRepository->find($id);

        return $this->render('user/detailuser.html.twig',[
            'detailparticipant' => $sortie,
            'user' => $user,
        ]);

    }

}