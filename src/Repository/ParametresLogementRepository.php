<?php

namespace App\Repository;

use App\Entity\ParametresLogement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ParametresLogement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametresLogement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametresLogement[]    findAll()
 * @method ParametresLogement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametresLogementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ParametresLogement::class);
    }

//    /**
//     * @return ParametresLogement[] Returns an array of ParametresLogement objects
//     */
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
    public function findOneBySomeField($value): ?ParametresLogement
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
