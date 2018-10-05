<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Logement
 *
 * @ORM\Table(name="logement", indexes={@ORM\Index(name="Logement_Types_Logement_FK", columns={"Id_type"})})
 * @ORM\Entity
 */
class Logement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_logement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLogement;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="NbVoyageur", type="integer", nullable=false)
     */
    private $nbvoyageur;

    /**
     * @var int
     *
     * @ORM\Column(name="NbLit", type="integer", nullable=false)
     */
    private $nblit;

    /**
     * @var int
     *
     * @ORM\Column(name="NbSalledeBain", type="integer", nullable=false)
     */
    private $nbsalledebain;

    /**
     * @var int
     *
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var \TypesLogement
     *
     * @ORM\ManyToOne(targetEntity="TypesLogement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_type", referencedColumnName="Id_type")
     * })
     */
    private $idType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commentaire", inversedBy="idLogement")
     * @ORM\JoinTable(name="commenter",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Id_logement", referencedColumnName="Id_logement")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Id_commentaire", referencedColumnName="Id_commentaire")
     *   }
     * )
     */
    private $idCommentaire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Activite", inversedBy="idLogement")
     * @ORM\JoinTable(name="proposer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Id_logement", referencedColumnName="Id_logement")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Id_activite", referencedColumnName="Id_activite")
     *   }
     * )
     */
    private $idActivite;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="idLogement")
     * @ORM\JoinTable(name="reservation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Id_logement", referencedColumnName="Id_logement")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Id_utilisateur", referencedColumnName="Id_utilisateur")
     *   }
     * )
     */
    private $idUtilisateur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCommentaire = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idActivite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUtilisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdLogement(): ?int
    {
        return $this->idLogement;
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

    public function getNbvoyageur(): ?int
    {
        return $this->nbvoyageur;
    }

    public function setNbvoyageur(int $nbvoyageur): self
    {
        $this->nbvoyageur = $nbvoyageur;

        return $this;
    }

    public function getNblit(): ?int
    {
        return $this->nblit;
    }

    public function setNblit(int $nblit): self
    {
        $this->nblit = $nblit;

        return $this;
    }

    public function getNbsalledebain(): ?int
    {
        return $this->nbsalledebain;
    }

    public function setNbsalledebain(int $nbsalledebain): self
    {
        $this->nbsalledebain = $nbsalledebain;

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

    public function getIdType(): ?TypesLogement
    {
        return $this->idType;
    }

    public function setIdType(?TypesLogement $idType): self
    {
        $this->idType = $idType;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getIdCommentaire(): Collection
    {
        return $this->idCommentaire;
    }

    public function addIdCommentaire(Commentaire $idCommentaire): self
    {
        if (!$this->idCommentaire->contains($idCommentaire)) {
            $this->idCommentaire[] = $idCommentaire;
        }

        return $this;
    }

    public function removeIdCommentaire(Commentaire $idCommentaire): self
    {
        if ($this->idCommentaire->contains($idCommentaire)) {
            $this->idCommentaire->removeElement($idCommentaire);
        }

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    public function getIdActivite(): Collection
    {
        return $this->idActivite;
    }

    public function addIdActivite(Activite $idActivite): self
    {
        if (!$this->idActivite->contains($idActivite)) {
            $this->idActivite[] = $idActivite;
        }

        return $this;
    }

    public function removeIdActivite(Activite $idActivite): self
    {
        if ($this->idActivite->contains($idActivite)) {
            $this->idActivite->removeElement($idActivite);
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->idUtilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if (!$this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur[] = $idUtilisateur;
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if ($this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur->removeElement($idUtilisateur);
        }

        return $this;
    }

}
