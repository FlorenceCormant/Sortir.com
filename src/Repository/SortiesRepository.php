<?php

namespace App\Repository;

use App\Entity\PropertySearch;
use App\Entity\Sorties;
use App\Form\PropertySearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

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

    // /**
    //  * @return Sorties[] Returns an array of Sorties objects
    //  */

    public function rechercher(PropertySearch $search)
    {

        $rechercher = $search->getNom();
        return $this->createQueryBuilder('u')
            ->Where('u.nom LIKE :word')
            ->setParameter('word', '%'.$rechercher.'%')
            ->getQuery()
            ->getResult();


    }

}
