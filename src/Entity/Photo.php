<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo", indexes={@ORM\Index(name="Photo_Logement_FK", columns={"Id_logement"})})
 * @ORM\Entity
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_photo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var \Logement
     *
     * @ORM\ManyToOne(targetEntity="Logement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_logement", referencedColumnName="Id_logement")
     * })
     */
    private $idLogement;

    public function getIdPhoto(): ?int
    {
        return $this->idPhoto;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdLogement(): ?Logement
    {
        return $this->idLogement;
    }

    public function setIdLogement(?Logement $idLogement): self
    {
        $this->idLogement = $idLogement;

        return $this;
    }


}
