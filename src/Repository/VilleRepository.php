<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    /**
     * Permet de récupérer les villes qui commencent par le terme recherché
     * @param   string     $_term
     * @return  array   
     */
    public function findByTerm($_term) {
        $result = array();
        if(!empty($_type)) {
            $conn = $this->getEntityManager()->getConnection();
            $query = 'SELECT v.*
                FROM ville v
                WHERE v.nom LIKE :term%
                ORDER BY v.nom';
            $stmt = $conn->prepare($query);
            $stmt->execute(['term' => $_term]);
            $result = $stmt->fetchAll();
        }        
        return $result;
    }
}
