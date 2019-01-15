<?php

namespace App\Entity;

use App\Entity\RolesUtilisateur;
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
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="id_utilisateur", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_utilisateur")
     */
    private $reservations;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logement", mappedBy="id_proprietaire")
     */
    private $logements;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cgv;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paiement", mappedBy="utilisateur")
     */
    private $paiements;

    public function __construct() {
        $this->valideUser = 0;
        $this->commentaires = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->logements = new ArrayCollection();
        $this->paiements = new ArrayCollection();
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

    public function getRole(): ?RolesUtilisateur
    {
        return $this->role;
    }

    public function setRole(?RolesUtilisateur $role): self
    {
        $this->role = $role;

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

    public function getRoles()
    {
        $roles = array();
        $roles[] = $this->role->getRole();
        return array_unique($roles);
    }
    
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
    }

    public function getUsername() {
        return $this->email;
    }

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

    /**
     * @return Collection|Logement[]
     */
    public function getLogements(): Collection
    {
        return $this->logements;
    }

    public function addLogement(Logement $logement): self
    {
        if (!$this->logements->contains($logement)) {
            $this->logements[] = $logement;
            $logement->setIdProprietaire($this);
        }

        return $this;
    }

    public function removeLogement(Logement $logement): self
    {
        if ($this->logements->contains($logement)) {
            $this->logements->removeElement($logement);
            // set the owning side to null (unless already changed)
            if ($logement->getIdProprietaire() === $this) {
                $logement->setIdProprietaire(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getCgv(): ?bool
    {
        return $this->cgv;
    }

    public function setCgv(bool $cgv): self
    {
        $this->cgv = $cgv;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * @return Collection|Paiement[]
     */
    public function getPaiements(): Collection
    {
        return $this->paies;
    }

    public function addPaiement(Paiement $paie): self
    {
        if (!$this->paies->contains($paie)) {
            $this->paies[] = $paie;
            $paie->setUtilisateur($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paie): self
    {
        if ($this->paies->contains($paie)) {
            $this->paies->removeElement($paie);
            // set the owning side to null (unless already changed)
            if ($paie->getUtilisateur() === $this) {
                $paie->setUtilisateur(null);
            }
        }

        return $this;
    }
}
