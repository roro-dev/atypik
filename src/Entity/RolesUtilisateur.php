<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RolesUtilisateur
 *
 * @ORM\Table(name="roles_utilisateur")
 * @ORM\Entity
 */
class RolesUtilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_role", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRole;

    /**
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=50, nullable=false)
     */
    private $role;

    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


}
