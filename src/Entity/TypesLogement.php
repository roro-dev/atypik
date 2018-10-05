<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypesLogement
 *
 * @ORM\Table(name="types_logement")
 * @ORM\Entity
 */
class TypesLogement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    public function getIdType(): ?int
    {
        return $this->idType;
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


}
