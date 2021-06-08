<?php

namespace App\Repository;

use App\Entity\PropertySearch;
use App\Entity\Sorties;
use App\Entity\User;
use App\Form\PropertySearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }


    public function total(PropertySearch $search, $user)
    {
        $qb = $this->createQueryBuilder('s');
        if ($search->getNom()) { //Requete pour une recherche par mot clé
            $qb->Where('s.nom LIKE :word');
            $qb->setParameter('word', '%' . $search->getNom() . '%');
        }

        if ($search->getVille()) {//Requete pour une recherche en fonction de la ville de la sortie
            $qb->leftJoin('s.no_lieu', 'noLieu');
            $qb->leftJoin('noLieu.no_ville', 'ville');
            $qb->andWhere('noLieu.no_ville = :ville');
            $qb->setParameter('ville', $search->getVille()->getId());
        }
        if ($search->getDate()) { //Requete pour rechercher une sortie en fonction de la date
            $qb->andWhere("DATE(s.date_debut) = DATE(:date)");
            $qb->setParameter('date', $search->getDate());
        }
        if ($search->getOrga() == true) { //Requete pour retourner la liste des sorties où l'utilisateur connecté est l'organisateur
            $qb->andwhere('s.organisateur = :orga');
            $qb->setParameter('orga', $user);
        }
        if ($search->getPasse() == true) { //Requete pour retourner la liste des sorties qui ont déjà eu lieu
            $qb->andwhere('s.date_cloture < :date');
            $qb->setParameter('date', new \DateTime('now'));
        }

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;


    }
}
