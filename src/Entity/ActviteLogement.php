<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActviteLogementRepository")
 */
class ActviteLogement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Logement", inversedBy="actviteLogements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_logement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activite", inversedBy="actviteLogements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_activite;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLogement(): ?Logement
    {
        return $this->id_logement;
    }

    public function setIdLogement(?Logement $id_logement): self
    {
        $this->id_logement = $id_logement;

        return $this;
    }

    public function getIdActivite(): ?Activite
    {
        return $this->id_activite;
    }

    public function setIdActivite(?Activite $id_activite): self
    {
        $this->id_activite = $id_activite;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
