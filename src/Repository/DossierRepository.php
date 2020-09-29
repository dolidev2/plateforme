<?php

namespace App\Repository;

use App\Entity\Dossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossier[]    findAll()
 * @method Dossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dossier::class);
    }

    // /**
    //  * @return Dossier[] Returns an array of Dossier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dossier
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $id
     * @return Dossier|null
     */
    public function findDossierService($id)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.service = :id')
            ->setParameter('id', $id)
            ->orderBy('d.updatedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDossierServiceLimit($id)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.service = :id')
            ->setParameter('id', $id)
            ->orderBy('d.updatedAt', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @param int $statut
     * @return Dossier|null
     */
    public function findDossierStatut($statut,$service)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.service = :service')
            ->setParameter('statut', $statut)
            ->setParameter('service',$service)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Dossier|null
     */
    public function findDossier()
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.updatedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

   


}
