<?php

namespace App\Repository;

use App\Entity\Logement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Logement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logement[]    findAll()
 * @method Logement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Logement::class);
    }

    /**
     * Permet de récupérer des logements grâce à des critères
     * @param   array   $_data
     * @return  Logement[]
     */
    public function findByCriteres($_data) {
        $result = array();
        if(!empty($_data) && is_array($_data)) {
            $conn = $this->getEntityManager()->getConnection();
            $query = 'SELECT l.*
                FROM logement l
                WHERE l.id_type_id = :type 
                AND l.nb_personne >= :nb';
            $stmt = $conn->prepare($query);
            $stmt->execute(['type' => $_data['type'], 'nb' => $_data['nb']]);
            $result = $stmt->fetchAll();
        }        
        return $result;
    }


//    /**
//     * @return Logement[] Returns an array of Logement objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Logement
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
