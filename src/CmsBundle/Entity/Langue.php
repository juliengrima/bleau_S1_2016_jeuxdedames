<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archive
 */
class Langue
{
    /**
     * @var int
     */
    private $id;


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
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $abréviation;


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Langue
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set abréviation
     *
     * @param string $abréviation
     *
     * @return Langue
     */
    public function setAbréviation($abréviation)
    {
        $this->abréviation = $abréviation;

        return $this;
    }

    /**
     * Get abréviation
     *
     * @return string
     */
    public function getAbréviation()
    {
        return $this->abréviation;
    }
}
