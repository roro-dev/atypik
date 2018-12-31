<?php

namespace App\Repository;

use App\Entity\ParametresType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ParametresType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametresType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametresType[]    findAll()
 * @method ParametresType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametresTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ParametresType::class);
    }

    /**
     * Permet de récupérer tous les paramètres pour un type donné
     * @param   int     $_param
     * @return  array   
     */
    public function findByType($_type) {
        $result = array();
        if(!empty($_type)) {
            $conn = $this->getEntityManager()->getConnection();
            $query = 'SELECT p.*
                FROM parametres_type p
                WHERE p.type_id = :type 
                GROUP BY p.id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['type' => $_type]);
            $result = $stmt->fetchAll();
        }        
        return $result;
    }

//    /**
//     * @return ParametresType[] Returns an array of ParametresType objects
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
    public function findOneBySomeField($value): ?ParametresType
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
