<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantsRepository::class)
 */
class Participants extends User

{

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="no_participant")
     */
    private $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity=Sorties::class, mappedBy="organisateur")
     */
    private $sorties;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="participants")
     */
    private $villes;





    public function getAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Inscriptions[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscriptions $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->addNoParticipant($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeNoParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Sorties[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sorties $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSorty(Sorties $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getOrganisateur() === $this) {
                $sorty->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function getVilles(): ?Villes
    {
        return $this->villes;
    }

    public function setVilles(?Villes $villes): self
    {
        $this->villes = $villes;

        return $this;
    }


}