<?php

namespace CmsBundle\Entity;

/**
 * Categorie
 */
class Categorie
{
    public function __toString()
    {
        return $this->nomDeLaCategorie;
    }

    //
  
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nomDeLaCategorie;

    /**
     * @var string
     */
    private $backgroundColor;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomDeLaCategorie
     *
     * @param string $nomDeLaCategorie
     *
     * @return Categorie
     */
    public function setNomDeLaCategorie($nomDeLaCategorie)
    {
        $this->nomDeLaCategorie = $nomDeLaCategorie;

        return $this;
    }

    /**
     * Get nomDeLaCategorie
     *
     * @return string
     */
    public function getNomDeLaCategorie()
    {
        return $this->nomDeLaCategorie;
    }

    /**
     * Set backgroundColor
     *
     * @param string $backgroundColor
     *
     * @return Categorie
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Get backgroundColor
     *
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $artiste;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artiste = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add artiste
     *
     * @param \CmsBundle\Entity\Artiste $artiste
     *
     * @return Categorie
     */
    public function addArtiste(\CmsBundle\Entity\Artiste $artiste)
    {
        $this->artiste[] = $artiste;

        return $this;
    }

    /**
     * Remove artiste
     *
     * @param \CmsBundle\Entity\Artiste $artiste
     */
    public function removeArtiste(\CmsBundle\Entity\Artiste $artiste)
    {
        $this->artiste->removeElement($artiste);
    }

    /**
     * Get artiste
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtiste()
    {
        return $this->artiste;
    }
}
