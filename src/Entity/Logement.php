<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogementRepository")
 */
class Logement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbVoyageur;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbLits;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSalledeBain;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeLogement", inversedBy="logements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_logement")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="id_logement", orphanRemoval=true)
     */
    private $commentaires;
    

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbVoyageur(): ?int
    {
        return $this->nbVoyageur;
    }

    public function setNbVoyageur(int $nbVoyageur): self
    {
        $this->nbVoyageur = $nbVoyageur;

        return $this;
    }

    public function getNbLits(): ?int
    {
        return $this->nbLits;
    }

    public function setNbLits(int $nbLits): self
    {
        $this->nbLits = $nbLits;

        return $this;
    }

    public function getNbSalledeBain(): ?int
    {
        return $this->nbSalledeBain;
    }

    public function setNbSalledeBain(int $nbSalledeBain): self
    {
        $this->nbSalledeBain = $nbSalledeBain;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdType(): ?TypeLogement
    {
        return $this->id_type;
    }

    public function setIdType(?TypeLogement $id_type): self
    {
        $this->id_type = $id_type;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setIdLogement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getIdLogement() === $this) {
                $reservation->setIdLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIdLogement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdLogement() === $this) {
                $commentaire->setIdLogement(null);
            }
        }

        return $this;
    }
}
