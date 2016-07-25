<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archive
 */
class Archive
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \CmsBundle\Entity\Langue
     */
    private $langue;


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
     * Set langue
     *
     * @param \CmsBundle\Entity\Langue $langue
     *
     * @return Archive
     */
    public function setLangue(\CmsBundle\Entity\Langue $langue = null)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \CmsBundle\Entity\Langue
     */
    public function getLangue()
    {
        return $this->langue;
    }
}
