<?php

namespace App\Repository;

use App\Entity\Lieux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

/**
 * @method Lieux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lieux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lieux[]    findAll()
 * @method Lieux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieux::class);
    }

    public function chercherlieuparville($villeid){
        $queryBuilder = $this->createQueryBuilder('s')
            ->where('s.no_ville =?1')
            ->setParameter(1,$villeid)
            ->getQuery()
            ->getResult();
            return $queryBuilder;
    }

    public function total(Lieux $lieux, $villesid)
    {
        $qb = $this->createQueryBuilder('s');
        if ($lieux->getNom()) { //Requete pour une recherche par mot clé
            $qb->Where('s.nom LIKE :word');
            $qb->andWhere('s.no_ville =?1');
            $qb->setParameter(1, $villesid);
            $qb->setParameter('word', '%' . $lieux->getNom() . '%');
        }

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;


    }


}
