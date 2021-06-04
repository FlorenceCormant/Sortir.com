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

        $qb =  $this->createQueryBuilder('u')
            ->Where('u.nom LIKE :word')
            ->setParameter('word', '%'.$search->getNom().'%')
            ->getQuery()
            ->getResult();
        return $qb;
    }

    public function searchVille(PropertySearch $search)
    {
        $qb =  $this->createQueryBuilder('s')
            ->leftJoin('s.no_lieu','noLieu')
            ->leftJoin('noLieu.no_ville','ville')
            ->Where('noLieu.no_ville = :ville')
            ->setParameter('ville', $search->getVille()->getId())
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function test(PropertySearch $search){
        if($search->getNom() != null && $search->getVille() !=null){
            //$test1 = $this->rechercher($search) + $this->searchVille($search);
            $test1 = $this->machin($search);
            return $test1;

        }else if ($search->getNom() == null && $search->getVille() != null){
            $test2 = $this->searchVille($search);
            return $test2;
        }
        else if ($search->getNom() != null && $search->getVille() == null){
            $test3 = $this->rechercher($search);
            return $test3;
        }else{
            return '';
        }

    }

    public function machin(PropertySearch $search)
    {
        $qb =  $this->createQueryBuilder('s')
            ->leftJoin('s.no_lieu','noLieu')
            ->leftJoin('noLieu.no_ville','ville')
            ->Where('noLieu.no_ville = :ville')
            ->setParameter('ville', $search->getVille()->getId())
            ->andWhere('s.nom LIKE :word')
            ->setParameter('word', '%'.$search->getNom().'%')
            ->getQuery()
            ->getResult();

        return $qb;
    }





}
