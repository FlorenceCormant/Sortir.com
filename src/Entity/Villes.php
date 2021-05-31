<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VillesRepository::class)
 */
class Villes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code_postal;

    /**
     * @ORM\OneToMany(targetEntity=Lieux::class, mappedBy="no_ville")
     */
    private $lieuxes;

    public function __construct()
    {
        $this->lieuxes = new ArrayCollection();
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

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @return Collection|Lieux[]
     */
    public function getLieuxes(): Collection
    {
        return $this->lieuxes;
    }

    public function addLieux(Lieux $lieux): self
    {
        if (!$this->lieuxes->contains($lieux)) {
            $this->lieuxes[] = $lieux;
            $lieux->setNoVille($this);
        }

        return $this;
    }

    public function removeLieux(Lieux $lieux): self
    {
        if ($this->lieuxes->removeElement($lieux)) {
            // set the owning side to null (unless already changed)
            if ($lieux->getNoVille() === $this) {
                $lieux->setNoVille(null);
            }
        }

        return $this;
    }
}
