<?php

namespace App\Repository;

use App\Entity\DateBuy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DateBuy|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateBuy|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateBuy[]    findAll()
 * @method DateBuy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateBuyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DateBuy::class);
    }

    // /**
    //  * @return DateBuy[] Returns an array of DateBuy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateBuy
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
