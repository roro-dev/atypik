<?php

namespace App\Repository;

use App\Entity\TypeLogement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeLogement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeLogement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeLogement[]    findAll()
 * @method TypeLogement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeLogementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeLogement::class);
    }

//    /**
//     * @return TypeLogement[] Returns an array of TypeLogement objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeLogement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
