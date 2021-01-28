<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    // /**
    //  * @return Facture[] Returns an array of Facture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findFactureOrder($type,$dateDebut, $dateFin)
    {
        return $this->createQueryBuilder('f')
            ->select('f.id','f.createdAt','f.client','f.description','u.prenom','u.nom', 'u.id as user')
            ->leftJoin('f.user','u')
            ->where('f.updatedAt > = :dayD')
            ->andWhere('f.updatedAt < = :dayF')
            ->andWhere('f.type = :type')
            ->setParameter('dayD',$dateDebut)
            ->setParameter('dayF', $dateFin)
            ->setParameter('type', $type)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }    

    public function findFactureByUser($user,$type)
    {
        return $this->createQueryBuilder('f')
            ->select('f.id','f.createdAt','f.client','f.description')
            ->leftJoin('f.user','u')
            ->orderBy('f.createdAt', 'DESC')
            ->andWhere('f.user = :userDirection') 
            ->andWhere('f.type = :type')
            ->setParameter('type', $type)
            ->setParameter('userDirection', $user)
            ->getQuery()
            ->getResult()
        ;
    }    
}
