<?php

namespace App\Repository;

use App\Entity\Sejours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sejours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sejours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sejours[]    findAll()
 * @method Sejours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SejoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sejours::class);
    }

    public function findAllJointure()
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'a', 'c', 'd')
            ->join('s.activite', 'a')
            ->join('a.categorie', 'c')
            ->join('s.dureeSejour', 'd')
            ->join('s.saisons','sai')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByForm($activite, $centre, $age, $saison, $duree= null)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s', 'a','cen','sai')
            ->join('s.centre','cen')
            ->join('cen.categorieCentre','cenCat')
            ->join('s.activite', 'a')
            ->join('s.saisons','sai');


        if ($activite != null && $activite != '') {
            $qb->andWhere('a.name LIKE :activite')
                ->setParameter('activite', '%'.$activite.'%');
        }
        if ($centre != null && $centre != '') {
            $qb->andWhere('cen.name LIKE :centre')
                ->setParameter('centre', '%'.$centre.'%');
        }
        if ($age != null && $age != '') {
            $qb->andWhere('s.ageMin <= :ageMin')
                ->setParameter('ageMin', $age)
                ->andWhere('s.ageMax >= :ageMax')
                ->setParameter('ageMax', $age);

        }
        if ($saison != null && $saison != '') {
            $qb->andWhere('sai.name = :saison')
                ->setParameter('saison', $saison);
        }
        if ($duree != null && $duree != '') {

            $qb->join('s.dureeSejour','ds','WITH','ds = :duree')
//                ->andWhere('s.dureeSejour = :duree')
                ->setParameter('duree', $duree);
        }

         return $qb
            ->getQuery()
            ->getResult();
    }

    public function findajaxSejours($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->andWhere('s.titre LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllByCentre($id)
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->andWhere('s.centre = :val')
            ->setParameter('val', $id)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByActivite($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.activite = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }


    public function counter()
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

    }


    // /**
    //  * @return Sejours[] Returns an array of Sejours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sejours
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
