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
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery('SELECT l
                FROM App\Entity\Logement l
                WHERE l.id_type = :type 
                AND l.nbPersonne >= :nb
                AND l.etat >= :etat
                ')
            ->setParameter('type', $_data['type'])
            ->setParameter('nb', $_data['nb'])
            ->setParameter('etat', $_data['etat']);
            $result = $query->execute();
        }        
        return $result;
    }
}
