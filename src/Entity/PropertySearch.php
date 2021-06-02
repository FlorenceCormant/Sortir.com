<?php
namespace App\Entity;


class PropertySearch{

    /**
     * @var string|null
     */
    private $nom;

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



}