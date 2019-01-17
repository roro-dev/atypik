<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteRepository")
 */
class Activite
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
     * @ORM\OneToMany(targetEntity="App\Entity\ActviteLogement", mappedBy="id_activite")
     */
    private $actviteLogements;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    public function __construct()
    {
        $this->actviteLogements = new ArrayCollection();
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

    /**
     * @return Collection|ActviteLogement[]
     */
    public function getActviteLogements(): Collection
    {
        return $this->actviteLogements;
    }

    public function addActviteLogement(ActviteLogement $actviteLogement): self
    {
        if (!$this->actviteLogements->contains($actviteLogement)) {
            $this->actviteLogements[] = $actviteLogement;
            $actviteLogement->setIdActivite($this);
        }

        return $this;
    }

    public function removeActviteLogement(ActviteLogement $actviteLogement): self
    {
        if ($this->actviteLogements->contains($actviteLogement)) {
            $this->actviteLogements->removeElement($actviteLogement);
            // set the owning side to null (unless already changed)
            if ($actviteLogement->getIdActivite() === $this) {
                $actviteLogement->setIdActivite(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
