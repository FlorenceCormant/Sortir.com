<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $code_Postal;

    /**
     * @ORM\OneToMany(targetEntity=Lieux::class, mappedBy="no_ville")
     * @Assert\NotBlank()
     */
    private $lieuxes;

    /**
     * @ORM\OneToMany(targetEntity=Participants::class, mappedBy="Villes")
     */
    private $participants;

    public function __construct()
    {
        $this->lieuxes = new ArrayCollection();
        $this->participants = new ArrayCollection();
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
        return $this->code_Postal;
    }

    public function setCodePostal(string $code_Postal): self
    {
        $this->code_Postal = $code_Postal;

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

    /**
     * @return Collection|Participants[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setVilles($this);
        }

        return $this;
    }

    public function removeParticipant(Participants $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getVilles() === $this) {
                $participant->setVilles(null);
            }
        }

        return $this;
    }

    public function  __toString()
    {
        return $this->nom;
    }
}
