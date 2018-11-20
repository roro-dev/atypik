<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametresTypeRepository")
 */
class ParametresType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeLogement", inversedBy="parametresType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParametresLogement", mappedBy="parametre")
     */
    private $parametresLogement;

    public function __construct()
    {
        $this->parametresLogement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TypeLogement
    {
        return $this->type;
    }

    public function setType(?TypeLogement $type): self
    {
        $this->type = $type;

        return $this;
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
     * @return Collection|ParametresLogement[]
     */
    public function getParametresLogement(): Collection
    {
        return $this->parametresLogement;
    }

    public function addParametresLogement(ParametresLogement $parametresLogement): self
    {
        if (!$this->parametresLogement->contains($parametresLogement)) {
            $this->parametresLogement[] = $parametresLogement;
            $parametresLogement->setParametre($this);
        }

        return $this;
    }

    public function removeParametresLogement(ParametresLogement $parametresLogement): self
    {
        if ($this->parametresLogement->contains($parametresLogement)) {
            $this->parametresLogement->removeElement($parametresLogement);
            // set the owning side to null (unless already changed)
            if ($parametresLogement->getParametre() === $this) {
                $parametresLogement->setParametre(null);
            }
        }

        return $this;
    }
}
