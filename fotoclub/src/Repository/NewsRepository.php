<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @return News[]|null
     */
    public function findAllEnabledNews(): array
    {
        return $this->createQueryBuilder('n')
            ->where("n.enabled = :enabled")
            ->setParameter('enabled', true)
            ->orderBy('n.dateCreated', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByYearAndMonth($year, $month): array
    {
        $qb = $this->createQueryBuilder('n');
        return $qb->where('n.enabled = :enabled')
            ->andWhere($qb->expr()->eq('YEAR(n.dateCreated)', ':year'))
            ->andWhere($qb->expr()->eq('MONTH(n.dateCreated)', ':month'))
            ->setParameter('enabled', true)
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->orderBy('n.dateCreated', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
