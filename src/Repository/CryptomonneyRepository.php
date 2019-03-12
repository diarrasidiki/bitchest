<?php

namespace App\Repository;

use App\Entity\Cryptomonney;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cryptomonney|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cryptomonney|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cryptomonney[]    findAll()
 * @method Cryptomonney[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptomonneyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cryptomonney::class);
    }

    // /**
    //  * @return Cryptomonney[] Returns an array of Cryptomonney objects
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
    public function findOneBySomeField($value): ?Cryptomonney
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
