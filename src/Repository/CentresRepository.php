<?php

namespace App\Repository;

use App\Entity\Centres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Centres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centres[]    findAll()
 * @method Centres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centres::class);
    }

    public function findByCategorie($value)
    {
        return $this->createQueryBuilder('c')
            ->select('c','cat')
            ->join('c.categorieCentre','cat')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->orderBy('c.name', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findajaxCentre($value,$name)
    {
        return $this->createQueryBuilder('c')
            ->select('c','cat')
            ->join('c.categorieCentre','cat')
            ->where('cat.name= :name')
            ->setParameter('name',$name)
            ->andWhere('c.name LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function count($value){
        return $this->createQueryBuilder('c')
            ->join('c.categorieCentre','cat')
            ->select('count(c.id)')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function findAllOfOne($id): ?Centres
    {
        return $this->createQueryBuilder('c')
            ->select('c','s')
            ->leftJoin('c.sejours','s')
            ->andWhere('c.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function counter()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

    }


    // /**
    //  * @return Centres[] Returns an array of Centres objects
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
    public function findOneBySomeField($value): ?Centres
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
