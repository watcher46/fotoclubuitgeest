<?php

namespace App\Repository;

use App\Entity\Agenda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Agenda|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agenda|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agenda[]    findAll()
 * @method Agenda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgendaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agenda::class);
    }

    /**
     * @return Agenda[]|null
     */
    public function findAllEnabledEvents(): array
    {
        return $this->createQueryBuilder('n')
            ->where("n.enabled = :enabled")
            ->setParameter('enabled', true)
            ->orderBy('n.eventDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllFutureEvents(): array
    {
        return $this->createQueryBuilder('n')
            ->where("n.enabled = :enabled")
            ->andWhere('n.eventDate >= NOW()')
            ->setParameter('enabled', true)
            ->orderBy('n.eventDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByYearAndMonth($year, $month): array
    {
        $qb = $this->createQueryBuilder('n');
        return $qb->where('n.enabled = :enabled')
            ->andWhere($qb->expr()->eq('YEAR(n.eventDate)', ':year'))
            ->andWhere($qb->expr()->eq('MONTH(n.eventDate)', ':month'))
            ->setParameter('enabled', true)
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->orderBy('n.eventDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Agenda[] Returns an array of Agenda objects
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
    public function findOneBySomeField($value): ?Agenda
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
