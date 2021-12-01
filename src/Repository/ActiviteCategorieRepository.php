<?php

namespace App\Repository;

use App\Entity\ActiviteCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActiviteCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiviteCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiviteCategorie[]    findAll()
 * @method ActiviteCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActiviteCategorie::class);
    }

    public function counter()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

    }


    // /**
    //  * @return ActiviteCategorie[] Returns an array of ActiviteCategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActiviteCategorie
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
