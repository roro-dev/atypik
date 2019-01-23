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
     * @return  Collection|Logement[]
     */
    public function findByCriteres($_data) {
        $result = array();
        if(!empty($_data) && is_array($_data)) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery('SELECT l
                FROM App\Entity\Logement l
                WHERE l.etat >= :etat' 
                . ((!empty($_data['type'])) ? ' AND l.id_type = :type ' : ' AND l.id_type > :type ')
                . ' AND l.nbPersonne >= :nb')
            ->setParameter('etat', $_data['etat'])
            ->setParameter('type', $_data['type'])
            ->setParameter('nb', $_data['nb']);
            $result = $query->execute();
        }        
        return $result;
    }

    /**
     * Permet de récupérer des logements grâce à des critères et à la ville
     * @param   array   $_data
     * @return  Collection|Logement[]
     */
    public function findByCriteresAndVille($_data) {
        $result = array();
        if(!empty($_data) && is_array($_data)) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery('SELECT l
                FROM App\Entity\Logement l
                WHERE l.etat >= :etat' 
                . ((($_data['type'] > 0)) ? ' AND l.id_type = :type ' : ' AND l.id_type > :type ')
                . ' AND l.nbPersonne >= :nb
                AND l.ville = :ville')
            ->setParameter('etat', $_data['etat'])
            ->setParameter('type', $_data['type'])
            ->setParameter('nb', $_data['nb'])
            ->setParameter('ville', $_data['ville']);
            $result = $query->execute();
        }        
        return $result;
    }

    /**
     * Permet d'éxécuter la recherche de logement selon des criteres
     * @param   array   $_data
     * @return  array
     */
    public function findByCriteresApi($_data) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM logement l 
        WHERE etat = 1";
        $params = array();
        if(array_key_exists('type', $_data) && !empty($_data['type'])) {
            $sql .= " AND id_type_id = :type ";
            $params['type'] = $_data['type'];
        }
        if(array_key_exists('nb', $_data) && !empty($_data['nb'])) {
            $sql .= " AND nb_personne <= :nb ";
            $params['nb'] = $_data['nb'];
        }
        if(array_key_exists('ville', $_data) && !empty($_data['ville'])) {
            $sql .= " AND ville_id = :ville ";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
