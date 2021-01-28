<?php

namespace App\Repository;

use App\Entity\Creation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Creation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creation[]    findAll()
 * @method Creation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreationRepository extends ServiceEntityRepository
{
  

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creation::class);
    }

    // /**
    //  * @return Creation[] Returns an array of Creation objects
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
    public function findOneBySomeField($value): ?Creation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

   
    public function findCreationOrder($type)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id','c.createdAt','c.client','c.description','c.statut','c.emetteur','u.prenom','u.nom', 'u.id as user')
            ->leftJoin('c.user','u')
            ->andWhere('c.type = :type')
            ->setParameter('type', $type)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }    

    public function findCreationByUser($user)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id','c.createdAt','c.client','c.description','c.statut','c.emetteur','c.type')
            ->leftJoin('c.user','u')
            ->orderBy('c.createdAt', 'DESC')
            ->andWhere('c.user = :userPao')
            ->setParameter('userPao', $user)
            ->getQuery()
            ->getResult()
        ;
    }    
}
