<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="Commentaire_Utilisateur_FK", columns={"Id_utilisateur"})})
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_commentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Contenu", type="string", length=300, nullable=false)
     */
    private $contenu;

    /**
     * @var int
     *
     * @ORM\Column(name="Note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_utilisateur", referencedColumnName="Id_utilisateur")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Logement", mappedBy="idCommentaire")
     */
    private $idLogement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLogement = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCommentaire(): ?int
    {
        return $this->idCommentaire;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

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
            $idLogement->addIdCommentaire($this);
        }

        return $this;
    }

    public function removeIdLogement(Logement $idLogement): self
    {
        if ($this->idLogement->contains($idLogement)) {
            $this->idLogement->removeElement($idLogement);
            $idLogement->removeIdCommentaire($this);
        }

        return $this;
    }

}
