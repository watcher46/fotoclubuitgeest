<?php

namespace App\Repository;

use App\Entity\Gallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gallery[]    findAll()
 * @method Gallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gallery::class);
    }

    // /**
    //  * @return Gallery[] Returns an array of Gallery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gallery
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneWithSortedImages(int $id, string $sort, bool $active = true): ?Gallery
    {
        if (empty($sort)) {
            $sort = 'ASC';
        }

        return $this->createQueryBuilder('g')
            ->select('g', 'i')
            ->leftJoin('g.images', 'i')
            ->andWhere('g.id = :id')
            ->andWhere('g.active = :active')
            ->orderBy('i.sortOrder', $sort)
            ->setParameter('id', $id)
            ->setParameter('active', $active)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOneWithSortedImagesByDate(int $id, string $sort): ?Gallery
    {
        return $this->createQueryBuilder('g')
            ->select('g', 'i')
            ->leftJoin('g.images', 'i')
            ->andWhere('g.id = :id')
            ->andWhere('g.active = :active')
            ->orderBy('i.dateCreated', $sort)
            ->setParameter('id', $id)
            ->setParameter('active', true)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @return Gallery
     */
    public function findRandomActiveGallery()
    {
        return $this->createQueryBuilder('g')
            ->select('g.id')
            ->leftJoin('g.member', 'm')
            ->andWhere('g.active = :active')
            ->andWhere('m.active = :active')
            ->orderBy('RAND()')
            ->setParameter('active', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findActiveGallery(int $id)
    {
        return $this->findOneWithSortedImages($id, 'ASC', true);
    }
}
