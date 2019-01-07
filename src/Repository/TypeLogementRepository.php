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
    
    /**
     * Permet de récupérer les noms des types de logement
     * @return  array   
     */
    public function findAllTypes() {
        $result = array();
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT DISTINCT t.type
            FROM App\Entity\TypeLogement t
            ORDER BY t.type
            ');
        $result = $query->execute();
        return $result;
    }
}
