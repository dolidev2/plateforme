<?php

namespace App\Repository;

use App\Entity\Comptabilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comptabilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comptabilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comptabilite[]    findAll()
 * @method Comptabilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptabiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comptabilite::class);
    }

    // /**
    //  * @return Comptabilite[] Returns an array of Comptabilite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comptabilite
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findDossierByStatut($statut)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.statut = :statut')
            ->setParameter('statut', $statut)
            ->orderBy('c.updatedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDossierOneByStatut($comptablite,$statut)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.statut = :statut')
            ->andWhere('c.id = :id')
            ->setParameter('statut', $statut)
            ->setParameter('id', $comptablite)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
