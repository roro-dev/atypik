<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeLogementRepository")
 */
class TypeLogement
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logement", mappedBy="id_type")
     */
    private $logements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParametresType", mappedBy="type")
     */
    private $parametresType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pathImg;

    public function __construct()
    {
        $this->logements = new ArrayCollection();
        $this->parametresType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $logement->setIdType($this);
        }

        return $this;
    }

    public function removeLogement(Logement $logement): self
    {
        if ($this->logements->contains($logement)) {
            $this->logements->removeElement($logement);
            // set the owning side to null (unless already changed)
            if ($logement->getIdType() === $this) {
                $logement->setIdType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ParametresType[]
     */
    public function getParametresType(): Collection
    {
        return $this->parametresType;
    }

    public function addParametresType(ParametresType $parametresType): self
    {
        if (!$this->parametresType->contains($parametresType)) {
            $this->parametresType[] = $parametresType;
            $parametresType->setType($this);
        }

        return $this;
    }

    public function removeParametresType(ParametresType $parametresType): self
    {
        if ($this->parametresType->contains($parametresType)) {
            $this->parametresType->removeElement($parametresType);
            // set the owning side to null (unless already changed)
            if ($parametresType->getType() === $this) {
                $parametresType->setType(null);
            }
        }

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->pathImg;
    }

    public function setPathImg(?string $pathImg): self
    {
        $this->pathImg = $pathImg;

        return $this;
    }
}
