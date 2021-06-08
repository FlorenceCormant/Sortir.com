<?php

namespace App\Repository;

use App\Entity\Participants;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participants[]    findAll()
 * @method Participants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participants::class);
    }


    public function findOrganisateur(User $userid){
        $queryBuilder = $this->createQueryBuilder('s')
            ->where('s.id = ?1')
            ->setParameter(1, $userid->getId())
            ->getQuery()
            ->getResult();

        return $queryBuilder;

    }
}
