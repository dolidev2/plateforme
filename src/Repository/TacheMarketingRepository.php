<?php

namespace App\Repository;

use App\Entity\TacheMarketing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TacheMarketing|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheMarketing|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheMarketing[]    findAll()
 * @method TacheMarketing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheMarketingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TacheMarketing::class);
    }

    // /**
    //  * @return TacheMarketing[] Returns an array of TacheMarketing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TacheMarketing
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

   
    public function findTacheByProgramme($programme)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.programme = :programme')
            ->setParameter('programme', $programme)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
