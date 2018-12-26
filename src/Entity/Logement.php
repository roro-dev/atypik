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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActviteLogement", mappedBy="id_logement")
     */
    private $actviteLogements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="id_logement")
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="logements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proprietaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParametresLogement", mappedBy="logement")
     */
    private $parametresLogement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="logements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPersonne;
    

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->actviteLogements = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->parametresLogement = new ArrayCollection();
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

    /**
     * @return Collection|ActviteLogement[]
     */
    public function getActivites(): Collection
    {
        return $this->actviteLogements;
    }

    public function addActivite(ActviteLogement $actviteLogement): self
    {
        if (!$this->actviteLogements->contains($actviteLogement)) {
            $this->actviteLogements[] = $actviteLogement;
            $actviteLogement->setIdLogement($this);
        }

        return $this;
    }

    public function removeActivite(ActviteLogement $actviteLogement): self
    {
        if ($this->actviteLogements->contains($actviteLogement)) {
            $this->actviteLogements->removeElement($actviteLogement);
            // set the owning side to null (unless already changed)
            if ($actviteLogement->getIdLogement() === $this) {
                $actviteLogement->setIdLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setIdLogement($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getIdLogement() === $this) {
                $photo->setIdLogement(null);
            }
        }

        return $this;
    }

    public function getIdProprietaire(): ?Utilisateur
    {
        return $this->id_proprietaire;
    }

    public function setIdProprietaire(?Utilisateur $id_proprietaire): self
    {
        $this->id_proprietaire = $id_proprietaire;

        return $this;
    }

    /**
     * @return Collection|ParametresLogement[]
     */
    public function getParametres(): Collection
    {
        return $this->parametresLogement;
    }

    public function addParametre(ParametresLogement $parametresLogement): self
    {
        if (!$this->parametresLogement->contains($parametresLogement)) {
            $this->parametresLogement[] = $parametresLogement;
            $parametresLogement->setLogement($this);
        }

        return $this;
    }

    public function removeParametre(ParametresLogement $parametresLogement): self
    {
        if ($this->parametresLogement->contains($parametresLogement)) {
            $this->parametresLogement->removeElement($parametresLogement);
            // set the owning side to null (unless already changed)
            if ($parametresLogement->getLogement() === $this) {
                $parametresLogement->setLogement(null);
            }
        }

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne(int $nbPersonne): self
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }
}
