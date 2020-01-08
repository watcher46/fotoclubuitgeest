<?php

namespace App\Repository;

use App\Entity\CompetitionImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompetitionImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionImage[]    findAll()
 * @method CompetitionImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompetitionImage::class);
    }

    // /**
    //  * @return CompetitionImage[] Returns an array of CompetitionImage objects
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
    public function findOneBySomeField($value): ?CompetitionImage
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
