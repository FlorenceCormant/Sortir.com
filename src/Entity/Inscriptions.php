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
     * @ORM\ManyToOne(targetEntity=sorties::class, inversedBy="inscriptions")
     */
    private $no_sortie;
    /**
     * @ORM\ManyToOne(targetEntity=Participants::class, inversedBy="userinscription")
     */
    private $userinscription;

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
    public function getNoSortie(): ?sorties
    {
        return $this->no_sortie;
    }
    public function setNoSortie(?sorties $no_sortie): self
    {
        $this->no_sortie = $no_sortie;
        return $this;
    }
    public function getUserinscription(): ?Participants
    {
        return $this->userinscription;
    }
    public function setUserinscription(?Participants $userinscription): self
    {
        $this->userinscription = $userinscription;
        return $this;
    }
}