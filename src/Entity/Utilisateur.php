<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="Utilisateur_Roles_Utilisateur_FK", columns={"Id_role"})})
 * @ORM\Entity
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=15, nullable=false)
     */
    private $telephone;

    /**
     * @var \RolesUtilisateur
     *
     * @ORM\ManyToOne(targetEntity="RolesUtilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_role", referencedColumnName="Id_role")
     * })
     */
    private $idRole;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TypePaiement", mappedBy="idUtilisateur")
     */
    private $idPaiement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Logement", mappedBy="idUtilisateur")
     */
    private $idLogement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPaiement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idLogement = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
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

    public function getTelphone(): ?string
    {
        return $this->telphone;
    }

    public function setTelphone(string $telphone): self
    {
        $this->telphone = $telphone;

        return $this;
    }

    public function getIdRole(): ?RolesUtilisateur
    {
        return $this->idRole;
    }

    public function setIdRole(?RolesUtilisateur $idRole): self
    {
        $this->idRole = $idRole;

        return $this;
    }

    /**
     * @return Collection|TypePaiement[]
     */
    public function getIdPaiement(): Collection
    {
        return $this->idPaiement;
    }

    public function addIdPaiement(TypePaiement $idPaiement): self
    {
        if (!$this->idPaiement->contains($idPaiement)) {
            $this->idPaiement[] = $idPaiement;
            $idPaiement->addIdUtilisateur($this);
        }

        return $this;
    }

    public function removeIdPaiement(TypePaiement $idPaiement): self
    {
        if ($this->idPaiement->contains($idPaiement)) {
            $this->idPaiement->removeElement($idPaiement);
            $idPaiement->removeIdUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Logement[]
     */
    public function getIdLogement(): Collection
    {
        return $this->idLogement;
    }

    public function addIdLogement(Logement $idLogement): self
    {
        if (!$this->idLogement->contains($idLogement)) {
            $this->idLogement[] = $idLogement;
            $idLogement->addIdUtilisateur($this);
        }

        return $this;
    }

    public function removeIdLogement(Logement $idLogement): self
    {
        if ($this->idLogement->contains($idLogement)) {
            $this->idLogement->removeElement($idLogement);
            $idLogement->removeIdUtilisateur($this);
        }

        return $this;
    }

}
