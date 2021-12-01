<?php

namespace App\Repository;

use App\Entity\ClasseDecouverteCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClasseDecouverteCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClasseDecouverteCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClasseDecouverteCategorie[]    findAll()
 * @method ClasseDecouverteCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseDecouverteCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasseDecouverteCategorie::class);
    }

    // /**
    //  * @return ClasseDecouverteCategorie[] Returns an array of ClasseDecouverteCategorie objects
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
    public function findOneBySomeField($value): ?ClasseDecouverteCategorie
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
