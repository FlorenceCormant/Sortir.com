<?php
namespace App\Entity;


class PropertySearch{

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var string|null
     */
    private $ville;

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
     * @return string|null
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @param string|null $ville
     * @return PropertySearch
     */
    public function setVille(?string $ville): PropertySearch
    {
        $this->ville = $ville;
        return $this;
    }





}