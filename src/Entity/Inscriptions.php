<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscriptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;

    /**
     * @ORM\ManyToMany(targetEntity=Participants::class, inversedBy="inscriptions")
     */
    private $no_participant;

    /**
     * @ORM\ManyToOne(targetEntity=sorties::class, inversedBy="inscriptions")
     */
    private $no_sortie;

    public function __construct()
    {
        $this->no_participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection|Participants[]
     */
    public function getNoParticipant(): Collection
    {
        return $this->no_participant;
    }

    public function addNoParticipant(Participants $noParticipant): self
    {
        if (!$this->no_participant->contains($noParticipant)) {
            $this->no_participant[] = $noParticipant;
        }

        return $this;
    }

    public function removeNoParticipant(Participants $noParticipant): self
    {
        $this->no_participant->removeElement($noParticipant);

        return $this;
    }

    public function getNoSortie(): ?sorties
    {
        return $this->no_sortie;
    }

    public function setNoSortie(?sorties $no_sortie): self
    {
        $this->no_sortie = $no_sortie;

        return $this;
    }
}
