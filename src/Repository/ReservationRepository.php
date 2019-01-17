<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Permet de récupérer les anciennes réservations d'un utilisateur
     * @param   Utilisateur $_utilisateur
     * @param   string      $_date
     * @return  Collection|Reservation[]
     */
    public function findAnciennesReservations($_user, $_date) {
        if(!empty($_user) && !empty($_date)) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                'SELECT r
                FROM App\Entity\Reservation r
                WHERE r.id_utilisateur = :user
                AND r.date_debut <= :date
                ORDER BY r.date_debut'
            )
            ->setParameter('user', $_user)
            ->setParameter('date', $_date);
            $result = $query->execute();
            return $result;
        }
        return null;
    }

    /**
     * Permet de récupérer les prochaines réservations d'un utilisateur
     * @param   Utilisateur $_utilisateur
     * @param   string      $_date
     * @return  Collection|Reservation[]
     */
    public function findProchainesReservations($_user, $_date) {
        if(!empty($_user) && !empty($_date)) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                'SELECT r
                FROM App\Entity\Reservation r
                WHERE r.id_utilisateur = :user
                AND r.date_debut > :date
                ORDER BY r.date_debut'
            )
            ->setParameter('user', $_user)
            ->setParameter('date', $_date);
            $result = $query->execute();
            return $result;
        }
        return null;
    }

    /**
     * Permet de récupérer les reservations d'un utilisateur et un logement donné
     * @param   Logement    $_logement
     * @param   Utilisateur $_utilisateur
     * @param   string      $_date
     * @return  Collection|Reservation[]
     */
    public function findResasBy($_logement, $_utilisateur, $_date) {
        $result = array();
        if(!empty($_logement) && !empty($_utilisateur) && !empty($_date)) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery('SELECT r
                FROM App\Entity\Reservation r
                WHERE r.id_logement = :logement
                AND r.id_utilisateur = :user
                AND r.date_fin < :date
                ')
                ->setParameter('logement', $_logement)
                ->setParameter('user', $_utilisateur)
                ->setParameter('date', $_date);
            $result = $query->execute();
        }        
        return $result;
    }
}
