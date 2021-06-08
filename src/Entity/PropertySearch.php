<?php

namespace App\Entity;

use DateTime;

class PropertySearch
{

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var Villes|null
     */
    private $ville;


    /**
     * @var DateTime|null
     */
    private $date;

    /**
     * @var boolean|null
     */
    private $orga;

    /**
     * @var boolean|null
     */
    private $inscrit;

    /**
     * @var boolean|null
     */
    private $pasInscrit;

    /**
     * @var boolean|null
     */
    private $passe;

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return PropertySearch
     */
    public function setNom(string $nom): PropertySearch
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return Villes|null
     */
    public function getVille(): ?Villes
    {
        return $this->ville;
    }

    /**
     * @param Villes|null $ville
     * @return PropertySearch
     */
    public function setVille(?Villes $ville): PropertySearch
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     * @return PropertySearch
     */
    public function setDate(?DateTime $date): PropertySearch
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOrga(): ?bool
    {
        return $this->orga;
    }

    /**
     * @param bool|null $orga
     * @return PropertySearch
     */
    public function setOrga(?bool $orga): PropertySearch
    {
        $this->orga = $orga;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getInscrit(): ?bool
    {
        return $this->inscrit;
    }

    /**
     * @param bool|null $inscrit
     * @return PropertySearch
     */
    public function setInscrit(?bool $inscrit): PropertySearch
    {
        $this->inscrit = $inscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPasInscrit(): ?bool
    {
        return $this->pasInscrit;
    }

    /**
     * @param bool|null $pasInscrit
     * @return PropertySearch
     */
    public function setPasInscrit(?bool $pasInscrit): PropertySearch
    {
        $this->pasInscrit = $pasInscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPasse(): ?bool
    {
        return $this->passe;
    }

    /**
     * @param bool|null $passe
     * @return PropertySearch
     */
    public function setPasse(?bool $passe): PropertySearch
    {
        $this->passe = $passe;
        return $this;
    }


}