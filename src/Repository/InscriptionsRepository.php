<?php

namespace App\Repository;

use App\Entity\Inscriptions;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscriptions[]    findAll()
 * @method Inscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscriptions::class);
    }


    public function deleteSortie($sortieid, $userid){
        $queryBuilder = $this->createQueryBuilder('s')
            ->where('s.no_sortie =?1')
            ->andWhere('s.userinscription =?2')
              ->setParameter(1, $sortieid)
                ->setParameter(2, $userid)

             ->getQuery()
            ->getResult();

            return $queryBuilder;
    }
}

