<?php

namespace App\Repository;

use App\Entity\CompetitionGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionGallery[]    findAll()
 * @method CompetitionGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionGalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionGallery::class);
    }

    // /**
    //  * @return CompetitionGallery[] Returns an array of CompetitionGallery objects
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
    public function findOneBySomeField($value): ?CompetitionGallery
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllActive()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = 1')
            ->orderBy('c.date_created', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findAllActiveInSeason(string $seasonStart, string $seasonEnd)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->where('c.active = 1')
            ->add('where', $qb->expr()->between('c.dateCreated', ':seasonStart', ':seasonEnd'))
            ->setParameter('seasonStart', $seasonStart)
            ->setParameter('seasonEnd', $seasonEnd)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
