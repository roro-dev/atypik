<?php

namespace App\Repository;

use App\Entity\ActviteLogement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActviteLogement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActviteLogement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActviteLogement[]    findAll()
 * @method ActviteLogement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActviteLogementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActviteLogement::class);
    }

//    /**
//     * @return ActviteLogement[] Returns an array of ActviteLogement objects
//     */
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
    public function findOneBySomeField($value): ?ActviteLogement
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
