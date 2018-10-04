<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity
 */
class Activite
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_activite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idActivite;

    /**
     * @var string
     *
     * @ORM\Column(name="NomActivite", type="string", length=255, nullable=false)
     */
    private $nomactivite;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Logement", mappedBy="idActivite")
     */
    private $idLogement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLogement = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdActivite(): ?int
    {
        return $this->idActivite;
    }

    public function getNomactivite(): ?string
    {
        return $this->nomactivite;
    }

    public function setNomactivite(string $nomactivite): self
    {
        $this->nomactivite = $nomactivite;

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
            $idLogement->addIdActivite($this);
        }

        return $this;
    }

    public function removeIdLogement(Logement $idLogement): self
    {
        if ($this->idLogement->contains($idLogement)) {
            $this->idLogement->removeElement($idLogement);
            $idLogement->removeIdActivite($this);
        }

        return $this;
    }

}
