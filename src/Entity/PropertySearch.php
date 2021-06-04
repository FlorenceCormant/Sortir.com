<?php
namespace App\Entity;

use DateTime;

class PropertySearch{

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





}