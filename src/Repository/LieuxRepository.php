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

}
