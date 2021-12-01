<?php

namespace App\Repository;

use App\Entity\ClasseDecouverte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClasseDecouverte|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClasseDecouverte|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClasseDecouverte[]    findAll()
 * @method ClasseDecouverte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseDecouverteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasseDecouverte::class);
    }

    public function findByCategorie($value)
    {
        return $this->createQueryBuilder('c')
            ->select('c','cat')
            ->join('c.categorie','cat')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->orderBy('cat.name', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findajaxClasse($value, $name)
    {
        return $this->createQueryBuilder('c')
            ->select('c','cat')
            ->join('c.categorie','cat')
            ->where('cat.name= :name')
            ->setParameter('name',$name)
            ->andWhere('c.titre LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function count($value){
        return $this->createQueryBuilder('c')
            ->join('c.categorie','cat')
            ->select('count(c.id)')
            ->andWhere('cat.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return ClasseDecouverte[] Returns an array of ClasseDecouverte objects
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
    public function findOneBySomeField($value): ?ClasseDecouverte
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
