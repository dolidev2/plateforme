<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
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
    public function findOneBySomeField($value): ?Commentaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findCommentDossier($dossier)
    {
        return $this->createQueryBuilder('c')
            ->select('c.content','c.id as contentId','c.updatedAt as commentDate',
                           'u.id as userId','u.prenom','u.nom','s.id as serviceId')
            ->leftJoin('c.user','u')
            ->leftJoin('u.service','s')
            ->andWhere('c.dossier = :val')
            ->setParameter('val', $dossier)
            ->orderBy('c.updatedAt', 'DESC')
            ->getQuery()
            ->getResult()
    ;
    }

    public function findDossierByComment($comment)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.dossier', 'd')
            ->andWhere('c.id= :val')
            ->setParameter('val',$comment)
            ->getQuery()
            ->getSingleResult()
            ;
    }

}
