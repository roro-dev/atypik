<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville", indexes={@ORM\Index(name="Ville_Utilisateur_FK", columns={"Id_utilisateur"})})
 * @ORM\Entity
 */
class Ville
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_ville", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVille;

    /**
     * @var string
     *
     * @ORM\Column(name="NomVille", type="string", length=50, nullable=false)
     */
    private $nomville;

    /**
     * @var int
     *
     * @ORM\Column(name="Taxe", type="integer", nullable=false)
     */
    private $taxe;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_utilisateur", referencedColumnName="Id_utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getIdVille(): ?int
    {
        return $this->idVille;
    }

    public function getNomville(): ?string
    {
        return $this->nomville;
    }

    public function setNomville(string $nomville): self
    {
        $this->nomville = $nomville;

        return $this;
    }

    public function getTaxe(): ?int
    {
        return $this->taxe;
    }

    public function setTaxe(int $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


}
