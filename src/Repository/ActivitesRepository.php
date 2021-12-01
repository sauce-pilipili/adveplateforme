<?php

namespace App\Repository;

use App\Entity\Activites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activites[]    findAll()
 * @method Activites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activites::class);
    }


    public function findByCategorie($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a','cat')
            ->join('a.categorie','cat')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->orderBy('cat.name', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function count($value){
        return $this->createQueryBuilder('a')
            ->join('a.categorie','cat')
            ->select('count(a.id)')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findajaxActivite($value, $name)
    {
        return $this->createQueryBuilder('a')
            ->select('a','cat')
            ->join('a.categorie','cat')
            ->where('cat.name= :name')
            ->setParameter('name',$name)
            ->andWhere('a.name LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Activites[] Returns an array of Activites objects
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
    public function findOneBySomeField($value): ?Activites
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
