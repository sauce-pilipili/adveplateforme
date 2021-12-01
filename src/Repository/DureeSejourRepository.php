<?php

namespace App\Repository;

use App\Entity\DureeSejour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DureeSejour|null find($id, $lockMode = null, $lockVersion = null)
 * @method DureeSejour|null findOneBy(array $criteria, array $orderBy = null)
 * @method DureeSejour[]    findAll()
 * @method DureeSejour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DureeSejourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DureeSejour::class);
    }

    public function findTheId($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    // /**
    //  * @return DureeSejour[] Returns an array of DureeSejour objects
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
    public function findOneBySomeField($value): ?DureeSejour
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
