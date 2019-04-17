<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Member::class);
    }

    // /**
    //  * @return Member[] Returns an array of Member objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Member[]
     */
    public function findActiveMembers()
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->andWhere('m.active = :active')
            ->orderBy('m.name', 'ASC')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     * @param string $sort
     * @param bool $active
     *
     * @return Member
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithSortedGalleries(int $id, string $sort = 'ASC', bool $active = true)
    {
        $sort = strtoupper($sort);
        if ($sort !== 'ASC' && $sort !== 'DESC') {
            $sort = 'ASC';
        }

        return $this->createQueryBuilder('m')
            ->select('m', 'g', 'i')
            ->leftJoin('m.galleries', 'g')
            ->leftJoin('g.images', 'i')
            ->andWhere('m.id = :id')
            ->andWhere('m.active = :memberActive')
            ->andWhere('g.active = :active')
            ->orderBy('g.dateCreated', $sort)
            ->setParameter('memberActive', true)
            ->setParameter('id', $id)
            ->setParameter('active', $active)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
