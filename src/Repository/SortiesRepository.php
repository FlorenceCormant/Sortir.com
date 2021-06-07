<?php

namespace App\Repository;

use App\Entity\PropertySearch;
use App\Entity\Sorties;
use App\Entity\User;
use App\Form\PropertySearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
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

    // /**
    //  * @return Sorties[] Returns an array of Sorties objects
    //  */

    public function motCle(PropertySearch $search) //Methode pour la recherche par nom de sortie
    {
//On compare ce qui est recupere dans le formulaire à ce qui est present dans la colonne nom des sorties
        $qb = $this->createQueryBuilder('u')
            ->Where('u.nom LIKE :word')
            ->setParameter('word', '%' . $search->getNom() . '%')
            ->getQuery()
            ->getResult();
        return $qb;
    }

    //Methode pour rechercher par ville, en utilisant l'ID de la ville
    public function ville(PropertySearch $search)
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.no_lieu', 'noLieu')
            ->leftJoin('noLieu.no_ville', 'ville')
            ->Where('noLieu.no_ville = :ville')
            ->setParameter('ville', $search->getVille()->getId())
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function date(PropertySearch $search)
    {
        $qb = $this->createQueryBuilder('s')
            ->where("DATE(s.date_debut) = DATE(:date)")
            ->setParameter('date', $search->getDate())
            ->getQuery()
            ->getResult();
        return $qb;

    }

    public function orga($user)
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.organisateur = :orga')
            ->setParameter('orga', $user)
            ->getQuery()
            ->getResult();
        return $qb;
    }

    public function passe()
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.date_cloture < :date')
            ->setParameter('date', new \DateTime('now') )
            ->getQuery()
            ->getResult();

        return $qb;
    }

//Methode pour requeter les 2 requetes precedente en meme temps et donc recupere les sorties ou le lieu et le nom correspondent à la sortie
    public function global(PropertySearch $search, $user)
    {
        if ($search->getNom() !== null) {
            $requete = $this->motCle($search);
            return $requete;
        }
        if ($search->getVille() !== null) {
            $requete = $this->ville($search);
            return $requete;
        }
        if ($search->getDate() !== null) {
            $requete = $this->date($search);
            return $requete;
        }
        if ($search->getOrga() !== null) {
            $requete = $this->orga($user);
            return $requete;
        }
        if ($search->getPasse() !== null) {
            $requete = $this->passe();
            return $requete;
        }
        return '';
    }
}
