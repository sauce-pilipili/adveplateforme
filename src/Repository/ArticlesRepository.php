<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function findByCategorie($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a','c')
            ->join('a.categorie','c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->orderBy('a.createdDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


    public function findSimilar($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.categorie = :val')
            ->setParameter('val', $value)
            ->orderBy('a.createdDate', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findajaxArticles($value, $name)
    {
        return $this->createQueryBuilder('a')
            ->select('a','cat')
            ->join('a.categorie','cat')
            ->where('cat.name= :name')
            ->setParameter('name',$name)
            ->andWhere('a.title LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function count($value){
        return $this->createQueryBuilder('a')
            ->join('a.categorie','c')
            ->select('count(a.id)')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findTheThreeLast()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdDate', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
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
    public function findOneBySomeField($value): ?Articles
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
