<?php

namespace App\Repository;


use App\Entity\Villes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Villes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Villes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Villes[]    findAll()
 * @method Villes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Villes::class);
    }

    public function total(Villes $villes)
    {
        $qb = $this->createQueryBuilder('s');
        if ($villes->getNom()) { //Requete pour une recherche par mot clé
            $qb->Where('s.nom LIKE :word');
            $qb->setParameter('word', '%' . $villes->getNom() . '%');
        }

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;


    }




}
