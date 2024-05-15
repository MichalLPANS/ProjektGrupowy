<?php

namespace App\Repository;

use App\Entity\Transakcje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transakcje>
 *
 * @method Transakcje|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transakcje|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transakcje[]    findAll()
 * @method Transakcje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransakcjeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transakcje::class);
    }

    //    /**
    //     * @return Transakcje[] Returns an array of Transakcje objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Transakcje
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
