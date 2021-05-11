<?php

namespace CoralMedia\Bundle\PrintingBundle\Repository;

use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrintingBatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrintingBatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrintingBatch[]    findAll()
 * @method PrintingBatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrintingBatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrintingBatch::class);
    }

    // /**
    //  * @return PrintingBatch[] Returns an array of PrintingBatch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrintingBatch
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
