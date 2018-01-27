<?php

namespace MobileBundle\Entity;

/**
 * MobileList
 */
class MobileList
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateDebut;

    /**
     * @var \DateTime
     */
    private $dateFin;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return MobileList
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return MobileList
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    /**
     * @var \CmsBundle\Entity\Commercant
     */
    private $commercants;

    /**
     * @var \CmsBundle\Entity\Artiste
     */
    private $artistess;


    /**
     * Set commercants
     *
     * @param \CmsBundle\Entity\Commercant $commercants
     *
     * @return MobileList
     */
    public function setCommercants(\CmsBundle\Entity\Commercant $commercants = null)
    {
        $this->commercants = $commercants;

        return $this;
    }

    /**
     * Get commercants
     *
     * @return \CmsBundle\Entity\Commercant
     */
    public function getCommercants()
    {
        return $this->commercants;
    }

    /**
     * Set artistess
     *
     * @param \CmsBundle\Entity\Artiste $artistess
     *
     * @return MobileList
     */
    public function setArtistess(\CmsBundle\Entity\Artiste $artistess = null)
    {
        $this->artistess = $artistess;

        return $this;
    }

    /**
     * Get artistess
     *
     * @return \CmsBundle\Entity\Artiste
     */
    public function getArtistess()
    {
        return $this->artistess;
    }
}
