<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametresLogementRepository")
 */
class ParametresLogement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ParametresType", inversedBy="parametresLogement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parametre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Logement", inversedBy="parametresLogement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $logement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParametre(): ?ParametresType
    {
        return $this->parametre;
    }

    public function setParametre(?ParametresType $parametre): self
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getLogement(): ?Logement
    {
        return $this->logement;
    }

    public function setLogement(?Logement $logement): self
    {
        $this->logement = $logement;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}
