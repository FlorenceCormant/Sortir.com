<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sorties
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
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_cloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_inscriptions_max;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_infos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat_sortie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_photo;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="no_sortie")
     */
    private $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=etats::class, inversedBy="sorties")
     */
    private $no_etat;

    /**
     * @ORM\ManyToOne(targetEntity=lieux::class, inversedBy="sorties")
     */
    private $no_lieu;

    /**
     * @ORM\ManyToOne(targetEntity=participants::class, inversedBy="sorties")
     */
    private $organisateur;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->date_cloture;
    }

    public function setDateCloture(\DateTimeInterface $date_cloture): self
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nb_inscriptions_max;
    }

    public function setNbInscriptionsMax(int $nb_inscriptions_max): self
    {
        $this->nb_inscriptions_max = $nb_inscriptions_max;

        return $this;
    }

    public function getDescriptionInfos(): ?string
    {
        return $this->description_infos;
    }

    public function setDescriptionInfos(string $description_infos): self
    {
        $this->description_infos = $description_infos;

        return $this;
    }

    public function getEtatSortie(): ?int
    {
        return $this->etat_sortie;
    }

    public function setEtatSortie(?int $etat_sortie): self
    {
        $this->etat_sortie = $etat_sortie;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->url_photo;
    }

    public function setUrlPhoto(?string $url_photo): self
    {
        $this->url_photo = $url_photo;

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
            $inscription->setNoSortie($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getNoSortie() === $this) {
                $inscription->setNoSortie(null);
            }
        }

        return $this;
    }

    public function getNoEtat(): ?etats
    {
        return $this->no_etat;
    }

    public function setNoEtat(?etats $no_etat): self
    {
        $this->no_etat = $no_etat;

        return $this;
    }

    public function getNoLieu(): ?lieux
    {
        return $this->no_lieu;
    }

    public function setNoLieu(?lieux $no_lieu): self
    {
        $this->no_lieu = $no_lieu;

        return $this;
    }

    public function getOrganisateur(): ?participants
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?participants $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }


}
