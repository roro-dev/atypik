<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TypePaiement
 *
 * @ORM\Table(name="type_paiement")
 * @ORM\Entity
 */
class TypePaiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_paiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="ModePaiement", type="string", length=50, nullable=false)
     */
    private $modepaiement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="idPaiement")
     * @ORM\JoinTable(name="payer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Id_paiement", referencedColumnName="Id_paiement")
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
        $this->idUtilisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPaiement(): ?int
    {
        return $this->idPaiement;
    }

    public function getModepaiement(): ?string
    {
        return $this->modepaiement;
    }

    public function setModepaiement(string $modepaiement): self
    {
        $this->modepaiement = $modepaiement;

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
