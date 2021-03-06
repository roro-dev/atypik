<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="email", message="Adresse mail déjà utilisé")
 */
class Utilisateur implements UserInterface
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RolesUtilisateur", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="id_utilisateur", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payer", mappedBy="id_utilisateur", orphanRemoval=true)
     */
    private $paiements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_utilisateur")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ville", mappedBy="id_utilisateur")
     */
    private $villes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valideUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tokenUser;

    public function __construct() {
        $this->valideUser = 0;
        $this->commentaires = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->villes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIdRole(): ?RolesUtilisateur
    {
        return $this->id_role;
    }

    public function setIdRole(?RolesUtilisateur $id_role): self
    {
        $this->id_role = $id_role;

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
            $commentaire->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdUtilisateur() === $this) {
                $commentaire->setIdUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Payer[]
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Payer $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removePaiement(Payer $paiement): self
    {
        if ($this->paiements->contains($paiement)) {
            $this->paiements->removeElement($paiement);
            // set the owning side to null (unless already changed)
            if ($paiement->getIdUtilisateur() === $this) {
                $paiement->setIdUtilisateur(null);
            }
        }

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
            $reservation->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getIdUtilisateur() === $this) {
                $reservation->setIdUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ville[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->contains($ville)) {
            $this->villes->removeElement($ville);
            // set the owning side to null (unless already changed)
            if ($ville->getIdUtilisateur() === $this) {
                $ville->setIdUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        $roles = array();
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    
    public function getSalt()
    {
    }
    public function eraseCredentials()
    {
    }

    public function getUsername() {}

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getValideUser(): ?bool
    {
        return $this->valideUser;
    }

    public function setValideUser(bool $valideUser): self
    {
        $this->valideUser = $valideUser;

        return $this;
    }

    public function getTokenUser(): ?string
    {
        return $this->tokenUser;
    }

    public function setTokenUser(string $tokenUser): self
    {
        $this->tokenUser = $tokenUser;

        return $this;
    }
}
