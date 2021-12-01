<?php

namespace App\Repository;

use App\Entity\CentresCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CentresCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentresCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentresCategories[]    findAll()
 * @method CentresCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentresCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentresCategories::class);
    }

    // /**
    //  * @return CentresCategories[] Returns an array of CentresCategories objects
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
    public function findOneBySomeField($value): ?CentresCategories
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
