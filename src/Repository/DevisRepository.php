<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    // /**
    //  * @return Devis[] Returns an array of Devis objects
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
    public function findOneBySomeField($value): ?Devis
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
     * @return mixed
     */
    public function findDevisDossier($id)
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.fournisseur','f')
            ->select('d.nomDevis','f.nomFournisseur')
            ->andWhere('d.dossier = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        ;
    }

    public function findDevisFournisseur($id)
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.fournisseur','f')
            ->select('f.nomFournisseur')
            ->andWhere('d.fournisseur = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        ;
    }

}
